<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Order;

class EditController extends Controller
{
    public function __invoke(int $orderId)
    {
        $order = Order::withTrashed()->where('id', $orderId)->with('orderer')->first();
        if ($order->deleted_at) {
            return back()->with(['error' => 'Сначала восстановите заказ, прежде чем редактировать его']);
        }
        return view('admin.order.edit', compact('order', 'order'));
    }
}
