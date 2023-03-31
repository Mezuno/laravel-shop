<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\UpdateRequest;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductTag;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class UpdateController extends Controller
{
    public function __invoke(Request $request, Order $order)
    {
        $data = $request->all();

        $order->update($data);

        return redirect()->route('order.show', compact('order'))->with(['success' => 'Заказ ID' . $order->id . ' успешно обновлен']);
    }
}
