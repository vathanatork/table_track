<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Order;
use App\Models\Restaurant;
use App\Models\Table;
use Illuminate\Http\Request;

class ShopController extends Controller
{

    private function getShopBranch($restaurant)
    {
        if (request()->branch && request()->branch != '') {
            return Branch::withoutGlobalScopes()->find(request()->branch);
        } else {
            return $restaurant->branches->first();
        }
    }

    private function getPackageModules($restaurant)
    {
        if (!$restaurant || !$restaurant->package) {
            return [];
        }

        $modules = $restaurant->package->modules->pluck('name')->toArray();
        $additionalFeatures = json_decode($restaurant->package->additional_features ?? '[]', true);

        return array_merge($modules, $additionalFeatures);
    }


    public function cart($hash)
    {
        $restaurant = Restaurant::with('currency')->where('hash', $hash)->first();
        $shopBranch = $this->getShopBranch($restaurant);
        $getTable = $restaurant->table_required ? true : false;

        return view('shop.index', [
            'restaurant' => $restaurant,
            'shopBranch' => $shopBranch,
            'getTable' => $getTable
        ]);
    }

    public function orderSuccess($id)
    {
        $order = Order::withoutGlobalScopes()->findOrFail($id);

        if (request()->branch && request()->branch != '') {
            $shopBranch = Branch::withoutGlobalScopes()->find(request()->branch);
        }
        else
        {
            $shopBranch = $order->branch;
        }
        return view('shop.order_success', ['restaurant' => $order->branch->restaurant, 'id' => $id, 'shopBranch' => $shopBranch]);

    }

    public function bookTable($hash)
    {
        $restaurant = Restaurant::with('currency')->where('hash', $hash)->firstOrFail();
        $shopBranch = $this->getShopBranch($restaurant);
        $packageModules = $this->getPackageModules($restaurant);

        abort_if(!in_array('Table Reservation', $packageModules), 403);

        return view('shop.book_a_table', [
            'restaurant' => $restaurant,
            'shopBranch' => $shopBranch
        ]);
    }

    public function myBookings($hash)
    {
        $restaurant = Restaurant::with('currency')->where('hash', $hash)->firstOrFail();
        $shopBranch = $this->getShopBranch($restaurant);
        $packageModules = $this->getPackageModules($restaurant);
        abort_if(!in_array('Table Reservation', $packageModules), 403);
        return view('shop.bookings', ['restaurant' => $restaurant, 'shopBranch' => $shopBranch]);
    }

    public function profile($hash)
    {
        $restaurant = Restaurant::with('currency')->where('hash', $hash)->firstOrFail();
        $shopBranch = $this->getShopBranch($restaurant);

        return view('shop.profile', ['restaurant' => $restaurant, 'shopBranch' => $shopBranch]);
    }

    public function myOrders($hash)
    {
        $restaurant = Restaurant::with('currency')->where('hash', $hash)->firstOrFail();
        $shopBranch = $this->getShopBranch($restaurant);

        return view('shop.orders', ['restaurant' => $restaurant, 'shopBranch' => $shopBranch]);
    }

    public function about($hash)
    {
        $restaurant = Restaurant::with('currency')->where('hash', $hash)->firstOrFail();
        $shopBranch = $this->getShopBranch($restaurant);

        return view('shop.about', ['restaurant' => $restaurant, 'shopBranch' => $shopBranch]);
    }

    public function contact($hash)
    {
        $restaurant = Restaurant::with('currency')->where('hash', $hash)->firstOrFail();
        $shopBranch = $this->getShopBranch($restaurant);

        return view('shop.contact', ['restaurant' => $restaurant, 'shopBranch' => $shopBranch]);
    }

    public function tableOrder($hash)
    {
        $table = Table::where('hash', $hash)->first();
        $getTable = false;

        if ($table) {
            $shopBranch = $table->branch;
            $restaurant = $table->branch->restaurant->load('currency');
        } else {
            $restaurant = Restaurant::with('currency')->where('id', $hash)->firstOrFail();
            $shopBranch = $this->getShopBranch($restaurant);
            $hash = null;
            $getTable = true;
        }

        return view('shop.index', [
            'tableHash' => $hash,
            'restaurant' => $restaurant,
            'shopBranch' => $shopBranch,
            'getTable' => $getTable
        ]);
    }
}
