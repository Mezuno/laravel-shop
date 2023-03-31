<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Order;

class RestoreController extends Controller
{
    public function __invoke(int $orderId)
    {
        Order::withTrashed()->find($orderId)->update(['deleted_at' => null]);
        $order = Order::find($orderId);
        return redirect()->route('order.show', compact('order'))->with(['success' => 'Заказ ID' . $order->id . ' успешно восстановлен']);
    }
}
