<?php

namespace App\Livewire\Dashboard;

use App\Models\Order;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class TodayOrders extends Component
{

    use LivewireAlert;

    public function render()
    {
        $count = Order::whereDate('orders.date_time', '>=', now()->startOfDay()->toDateTimeString())
        ->whereDate('orders.date_time', '<=', now()->endOfDay()->toDateTimeString())
        ->where('status', '<>', 'canceled')
        ->where('status', '<>', 'draft')
        ->count();

        $playSound = false;

        if (session()->has('today_order_count') && session('today_order_count') != $count) {
            $playSound = true;
            
            $this->alert('success', __('messages.newOrderReceived'), [
                'toast' => true,
                'position' => 'top-end'
            ]);

        }

        session(['today_order_count' => $count]);

        return view('livewire.dashboard.today-orders', [
            'count' => $count,
            'playSound' => $playSound
        ]);
    }

}
