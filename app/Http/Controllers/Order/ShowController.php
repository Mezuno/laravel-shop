<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Order;

class ShowController extends Controller
{
    public function __invoke(int $orderId)
    {
        $order = Order::withTrashed()->where('id', $orderId)->with('orderer')->first();
        return view('order.show', compact('order'));
    }
}
