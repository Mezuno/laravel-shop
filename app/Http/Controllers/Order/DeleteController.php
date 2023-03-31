<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Order;

class DeleteController extends Controller
{
    public function __invoke(Order $order)
    {
        $order->delete();
        return redirect()->route('order.index')->with(['success' => 'Заказ ID' . $order->id . ' успешно отменен']);
    }
}
