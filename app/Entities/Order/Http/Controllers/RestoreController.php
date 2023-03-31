<?php

namespace App\Entities\Order\Http\Controllers;

use App\Entities\Order\Models\Order;
use App\Http\Controllers\Controller;

class RestoreController extends Controller
{
    public function __invoke(int $orderId)
    {
        Order::withTrashed()->find($orderId)->update(['deleted_at' => null]);
        $order = Order::find($orderId);
        return redirect()->route('order.show', compact('order'))->with(['success' => 'Заказ ID' . $order->id . ' успешно восстановлен']);
    }
}
