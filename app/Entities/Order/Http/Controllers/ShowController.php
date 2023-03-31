<?php

namespace App\Entities\Order\Http\Controllers;

use App\Entities\Order\Models\Order;
use App\Http\Controllers\Controller;

class ShowController extends Controller
{
    public function __invoke(int $orderId)
    {
        $order = Order::withTrashed()->where('id', $orderId)->with('orderer')->first();
        return view('admin.order.show', compact('order'));
    }
}
