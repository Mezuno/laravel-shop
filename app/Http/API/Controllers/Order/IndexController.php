<?php

namespace App\Http\API\Controllers\Order;

use App\Entities\Order\Http\Resources\OrderResource;
use App\Entities\Order\Models\Order;
use App\Http\API\Requests\Order\IndexRequest;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function __invoke(IndexRequest $request)
    {
        $data = $request->validated();
        $orders = Order::where('user_id', $data['user_id'])->orderByDesc('id')->paginate(12, ['*'], 'page', $data['page'] ?? 1);
        return OrderResource::collection($orders);
    }
}
