<?php

namespace App\Livewire\Pos;

use App\Models\Kot;
use App\Models\Tax;
use App\Models\User;
use App\Models\Order;
use App\Models\Table;
use App\Models\KotItem;
use Livewire\Component;
use App\Models\MenuItem;
use App\Models\OrderTax;
use App\Models\OrderItem;
use App\Scopes\BranchScope;
use Livewire\Attributes\On;
use App\Models\ItemCategory;
use App\Models\DeliveryExecutive;
use App\Models\MenuItemVariation;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Pos extends Component
{
    use LivewireAlert;

    protected $listeners = ['refreshPos' => '$refresh'];


    public $categoryList;
    public $search;
    public $filterCategories;
    public $menuItem;
    public $subTotal;
    public $total;
    public $orderNumber;
    public $kotNumber;
    public $tableNo;
    public $tableId;
    public $users;
    public $noOfPax = 1;
    public $selectWaiter;
    public $taxes;
    public $orderNote;
    public $tableOrder;
    public $tableOrderID;
    public $orderType;
    public $kotList = [];
    public $showVariationModal = false;
    public $showKotNote = false;
    public $showTableModal = false;
    public $showErrorModal = true;
    public $orderDetail = false;
    public $orderItemList = [];
    public $orderItemVariation = [];
    public $orderItemQty = [];
    public $orderItemAmount = [];
    public $deliveryExecutives;
    public $selectDeliveryExecutive;
    public $orderID;

    public function mount()
    {
        $this->total = 0;
        $this->subTotal = 0;
        $this->categoryList = ItemCategory::all();
        $this->users = User::withoutGlobalScope(BranchScope::class)
            ->where(function($q) {
                return $q->where('branch_id', branch()->id)
                    ->orWhereNull('branch_id');
            })
            ->where('restaurant_id', restaurant()->id)
            ->get();
        $this->taxes = Tax::all();
        $this->orderNumber = Order::generateOrderNumber(branch());
        $this->selectWaiter = user()->id;
        $this->orderType = 'dine_in';
        $this->deliveryExecutives = DeliveryExecutive::where('status', 'available')->get();

        if ($this->tableOrderID) {
            $this->tableId = $this->tableOrderID;
            $this->tableOrder = Table::find($this->tableOrderID);
            $this->tableNo = $this->tableOrder->table_code;

            if ($this->tableOrder->activeOrder) {

                $this->orderNumber = $this->tableOrder->activeOrder->order_number;
                $this->showTableOrder();

                if ($this->orderDetail) {
                    $this->showOrderDetail();
                }

            } elseif ($this->orderDetail) {
                return $this->redirect(route('pos.index'), navigate: true);
            }
        }

        if ($this->orderID) {
            $order = Order::find($this->orderID);
            $this->orderNumber = $order->order_number;
            $this->noOfPax = $order->number_of_pax;
            $this->selectWaiter = $order->waiter_id ?? null;
            $this->tableNo = $order->table->table_code ?? null;
            $this->tableId = $order->table->id ?? null;

            if ($this->orderDetail) {
                $this->orderDetail = $order;
                $this->setupOrderItems();
            }
        }

    }

    public function showTableOrder()
    {
        $this->selectWaiter = $this->tableOrder->activeOrder->waiter_id;
        $this->noOfPax = $this->tableOrder->activeOrder->number_of_pax;
    }

    public function showOrderDetail()
    {
        $this->orderDetail = $this->tableOrder->activeOrder;
        $this->setupOrderItems();
    }

    public function showPayment($id)
    {
        $order = Order::find($id);

        if (is_null($order->customer_id)) {
            $this->alert('error', __('messages.addCustomerDetails'), [
                'toast' => true,
                'position' => 'top-end',
                'showCancelButton' => false,
                'cancelButtonText' => __('app.close')
            ]);

        } else {
            $this->dispatch('showPaymentModal', id: $order->id);
        }
    }

    public function setupOrderItems()
    {
        if ($this->orderDetail) {
            foreach ($this->orderDetail->kot as $kot) {
                $this->kotList['kot_' . $kot->id] = $kot;

                foreach ($kot->items as $item) {
                    $this->orderItemList['"kot_' . $kot->id . '_' . $item->id . '"'] = $item->menuItem;
                    $this->orderItemQty['"kot_' . $kot->id . '_' . $item->id . '"'] = $item->quantity;
                    $this->orderItemAmount['"kot_' . $kot->id . '_' . $item->id . '"'] = ($this->orderItemQty['"kot_' . $kot->id . '_' . $item->id . '"'] * ($item->menuItemVariation ? $item->menuItemVariation->price : $item->menuItem->price));

                    if ($item->menuItemVariation) {
                        $this->orderItemVariation['"kot_' . $kot->id . '_' . $item->id . '"'] = $item->menuItemVariation;
                    }

                }
            }

            $this->calculateTotal();
        }
    }

    public function addCartItems($id, $variationCount)
    {
        $this->dispatch('play_beep');
        $this->menuItem = MenuItem::find($id);

        if ($variationCount > 0) {
            $this->showVariationModal = true;

        } else {
            $this->syncCart($id);
        }
    }

    #[On('setTable')]
    public function setTable(Table $table)
    {
        $this->tableNo = $table->table_code;
        $this->tableId = $table->id;

        if ($this->orderID) {
            Order::where('id', $this->orderID)->update(['table_id' => $table->id]);

            if ($this->orderDetail->date_time->format('d-m-Y') == now()->format('d-m-Y')) {
                Table::where('id', $this->tableId)->update([
                    'available_status' => 'running'
                ]);
            }

            $this->orderDetail->fresh();
        }

        $this->showTableModal = false;
    }

    #[On('setPosVariation')]
    public function setPosVariation($variationId)
    {
        $this->showVariationModal = false;
        $menuItemVariation = MenuItemVariation::find($variationId);
        $this->orderItemVariation['"' . $menuItemVariation->menu_item_id . '_' . $variationId . '"'] = $menuItemVariation;
        $this->syncCart('"' . $menuItemVariation->menu_item_id . '_' . $variationId . '"');
    }

    public function syncCart($id)
    {
        if (!isset($this->orderItemList[$id])) {
            $this->orderItemList[$id] = $this->menuItem;
            $this->orderItemQty[$id] = $this->orderItemQty[$id] ?? 1;
            $this->orderItemAmount[$id] = ($this->orderItemQty[$id] * (isset($this->orderItemVariation[$id]) ? $this->orderItemVariation[$id]->price : $this->orderItemList[$id]->price));
            $this->calculateTotal();

        } else {
            $this->addQty($id);
        }
    }

    public function deleteCartItems($id)
    {
        unset($this->orderItemList[$id]);
        unset($this->orderItemQty[$id]);
        unset($this->orderItemAmount[$id]);
        unset($this->orderItemVariation[$id]);
        $this->calculateTotal();
    }

    public function deleteOrderItems($id)
    {
        OrderItem::destroy($id);

        if ($this->orderDetail) {
            $this->total = 0;
            $this->subTotal = 0;

            foreach ($this->orderDetail->items as $value) {
                $this->subTotal = ($this->subTotal + $value->amount);
                $this->total = ($this->total + $value->amount);
            }

            foreach ($this->taxes as $value) {
                $this->total = ($this->total + (($value->tax_percent / 100) * $this->subTotal));
            }

            Order::where('id', $this->orderDetail->id)->update([
                'sub_total' => $this->subTotal,
                'total' => $this->total
            ]);

        }

        $this->dispatch('refreshPos');
    }

    public function addQty($id)
    {
        $this->orderItemQty[$id] = isset($this->orderItemQty[$id]) ? ($this->orderItemQty[$id] + 1) : 1;
        $this->orderItemAmount[$id] = ($this->orderItemQty[$id] * (isset($this->orderItemVariation[$id]) ? $this->orderItemVariation[$id]->price : $this->orderItemList[$id]->price));
        $this->calculateTotal();
    }

    public function subQty($id)
    {
        $this->orderItemQty[$id] = (isset($this->orderItemQty[$id]) && $this->orderItemQty[$id] > 1) ? ($this->orderItemQty[$id] - 1) : 1;
        $this->orderItemAmount[$id] = ($this->orderItemQty[$id] * (isset($this->orderItemVariation[$id]) ? $this->orderItemVariation[$id]->price : $this->orderItemList[$id]->price));
        $this->calculateTotal();
    }

    public function calculateTotal()
    {
        $this->total = 0;
        $this->subTotal = 0;

        foreach ($this->orderItemAmount as $value) {
            $this->subTotal = ($this->subTotal + $value);
            $this->total = ($this->total + $value);
        }

        foreach ($this->taxes as $value) {
            $this->total = ($this->total + (($value->tax_percent / 100) * $this->subTotal));
        }
    }

    public function saveOrder($action, $secondAction = null)
    {
        $this->showErrorModal = true;

        $rules = [
            // 'noOfPax' => 'required_if:orderType,dine_in|numeric',
            // 'tableNo' => 'required_if:orderType,dine_in',
            'selectDeliveryExecutive' => 'required_if:orderType,delivery',
            'orderItemList' => 'required',
        ];

        if (!$this->orderID && !$this->tableOrderID) {
            $rules['selectWaiter'] = 'required_if:orderType,dine_in';
        }

        $messages = [
            'noOfPax.required_if' => __('messages.enterPax'),
            'tableNo.required_if' => __('messages.setTableNo'),
            'selectWaiter.required_if' => __('messages.selectWaiter'),
            'orderItemList.required' => __('messages.orderItemRequired'),
        ];

        $this->validate($rules, $messages);

        switch ($action) {
        case 'bill':
            $successMessage = __('messages.billedSuccess');
            $status = 'billed';
            $tableStatus = 'running';
            break;

        case 'kot':
            $successMessage = __('messages.kotGenerated');
            $status = 'kot';
            $tableStatus = 'running';
            break;
        }

        if ((!$this->tableOrderID && !$this->orderID) || ($this->tableOrderID && !$this->tableOrder->activeOrder)) {
            $order = Order::create([
                'order_number' => $this->orderNumber,
                'date_time' => now(),
                'table_id' => $this->tableId,
                'number_of_pax' => $this->noOfPax,
                'waiter_id' => $this->selectWaiter,
                'sub_total' => $this->subTotal,
                'total' => $this->total,
                'order_type' => $this->orderType,
                'delivery_executive_id' => ($this->orderType == 'delivery' ? $this->selectDeliveryExecutive : null),
                'status' => ($this->orderType == 'delivery' ? 'out_for_delivery' : $status)
            ]);

        } else {
            if ($this->orderID) {
                $this->orderDetail = Order::find($this->orderID);
            }

            $order = ($this->tableOrderID ? $this->tableOrder->activeOrder : $this->orderDetail);

            Order::where('id', $order->id)->update([
                'date_time' => now(),
                'number_of_pax' => $this->noOfPax,
                'waiter_id' => $this->selectWaiter,
                'table_id' => $this->tableId ?? $order->table_id,
                'sub_total' => $this->subTotal,
                'total' => $this->total,
                'status' => $status
            ]);

            $order->items()->delete();
            $order->taxes()->delete();
        }

        if ($status == 'kot') {
            $kot = Kot::create([
                'kot_number' => (Kot::generateKotNumber($order->branch) + 1),
                'order_id' => $order->id,
                'note' => $this->orderNote
            ]);

            foreach ($this->orderItemList as $key => $value) {
                KotItem::create([
                    'kot_id' => $kot->id,
                    'menu_item_id' => (isset($this->orderItemVariation[$key]) ? $this->orderItemVariation[$key]->menu_item_id : $key),
                    'menu_item_variation_id' => (isset($this->orderItemVariation[$key]) ? $this->orderItemVariation[$key]->id : null),
                    'quantity' => $this->orderItemQty[$key]
                ]);
            }
        }

        if ($status == 'billed') {

            foreach ($this->orderItemList as $key => $value) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_item_id' => (isset($this->orderItemVariation[$key]) ? $this->orderItemVariation[$key]->menu_item_id : $this->orderItemList[$key]->id),
                    'menu_item_variation_id' => (isset($this->orderItemVariation[$key]) ? $this->orderItemVariation[$key]->id : null),
                    'quantity' => $this->orderItemQty[$key],
                    'price' => (isset($this->orderItemVariation[$key]) ? $this->orderItemVariation[$key]->price : $value->price),
                    'amount' => $this->orderItemAmount[$key],
                ]);
            }

            foreach ($this->taxes as $key => $value) {
                OrderTax::create([
                    'order_id' => $order->id,
                    'tax_id' => $value->id
                ]);
            }

            $this->total = 0;
            $this->subTotal = 0;

            foreach ($order->load('items')->items as $value) {
                $this->subTotal = ($this->subTotal + $value->amount);
                $this->total = ($this->total + $value->amount);
            }

            foreach ($this->taxes as $value) {
                $this->total = ($this->total + (($value->tax_percent / 100) * $this->subTotal));
            }

            Order::where('id', $order->id)->update([
                'sub_total' => $this->subTotal,
                'total' => $this->total
            ]);

            $this->resetPos();

        }

        Table::where('id', $this->tableId)->update([
            'available_status' => $tableStatus
        ]);

        $this->dispatch('posOrderSuccess');

        $this->alert('success', $successMessage, [
            'toast' => true,
            'position' => 'top-end',
            'showCancelButton' => false,
            'cancelButtonText' => __('app.close')
        ]);

        if ($status == 'kot') {
            $this->dispatch('resetPos');
            // return $this->redirect(route('kots.index'), navigate: true);
        }

        if ($status == 'billed') {
            // return $this->redirect(route('orders.index'), navigate: true);
            switch ($secondAction) {
                case 'payment':
                    $this->dispatch('showPaymentModal', id: $order->id);
                    break;
                case 'print':
                    $url = route('orders.print', $order->id);
                    $this->dispatch('print_order', $url);
                    break;
                default:
                    $this->dispatch('showOrderDetail', id: $order->id);
                    break;
            }
        }

    }

    #[On('resetPos')]
    public function resetPos()
    {
        $this->search = null;
        $this->filterCategories = null;
        $this->menuItem = null;
        $this->subTotal = 0;
        $this->total = 0;
        $this->orderNumber = Order::latest()->first()->order_number + 1;
        $this->tableNo = null;
        $this->tableId = null;
        $this->noOfPax = null;
        $this->selectWaiter = user()->id;
        $this->orderItemList = [];
        $this->orderItemVariation = [];
        $this->orderItemQty = [];
        $this->orderItemAmount = [];
        $this->orderType = 'dine_in';
    }

    public function render()
    {

        $query = MenuItem::withCount('variations');

        if (!empty($this->filterCategories)) {
            $query = $query->where('item_category_id', $this->filterCategories);
        }

        $query = $query->search('item_name', $this->search)->get();

        return view('livewire.pos.pos', [
            'menuItems' => $query
        ]);
    }

}
