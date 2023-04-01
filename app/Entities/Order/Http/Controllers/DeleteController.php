<?php

namespace App\Entities\Order\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Entities\Order\Models\Order;

class DeleteController extends Controller
{
    public function __invoke(Order $order)
    {
        $order->delete();
        return redirect()->route('order.index')->with(['success' => 'Заказ ID' . $order->id . ' успешно отменен']);
    }
}
