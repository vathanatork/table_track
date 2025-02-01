<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\ReceiptSetting;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function index()
    {
        abort_if(!in_array('Order', restaurant_modules()), 403);
        abort_if((!user_can('Show Order')), 403);
        return view('order.index');
    }

    public function show($id)
    {
        return view('order.show', compact('id'));
    }

    public function printOrder($id)
    {
        $order = Order::find($id);
        $receiptSettings = restaurant()->receiptSetting;
        return view('order.print', compact('order', 'receiptSettings'));
    }
}
