<?php

namespace App\Entities\Order\Http\Controllers;

use App\Entities\Order\Models\Order;
use App\Http\Controllers\Controller;

class EditController extends Controller
{
    public function __invoke(int $orderId)
    {
        $order = Order::withTrashed()->where('id', $orderId)->with('user')->first();
        if ($order->deleted_at) {
            return back()->with(['error' => 'Сначала восстановите заказ, прежде чем редактировать его']);
        }
        return view('admin.order.edit', compact('order', 'order'));
    }
}
