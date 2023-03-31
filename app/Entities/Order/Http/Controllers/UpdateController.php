<?php

namespace App\Entities\Order\Http\Controllers;

use App\Entities\Order\Models\Order;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UpdateController extends Controller
{
    public function __invoke(Request $request, Order $order)
    {
        $data = $request->all();

        $order->update($data);

        return redirect()->route('order.show', compact('order'))->with(['success' => 'Заказ ID' . $order->id . ' успешно обновлен']);
    }
}
