<?php

namespace App\Entities\Order\Http\Controllers;

use App\Entities\Order\Http\Requests\IndexRequest;
use App\Entities\Order\Models\Order;
use App\Http\Controllers\Controller;
use App\Traits\AdminFilterHelperTrait;

class IndexController extends Controller
{
    use AdminFilterHelperTrait;

    public function __invoke(IndexRequest $request)
    {
        $query = Order::query();

        $validated = $request->validated();

        $limit = $this->getFilterSize($request, $validated);

        if (!$validated) {
            $orders = $query->with('user')->orderByDesc('id')->paginate($limit);
            return view('admin.order.index')->with(['orders' => $orders]);
        }

        $this->addWhereBetweenFilterToQuery($query, $request, $validated, 'total_price', 1, 1000000);
        $this->addWhereBoolFilterToQuery($query, $request, $validated, 'payment_status');

        $orders = $query->withTrashed()->with('user')->orderByDesc('id')->get();

        $this->addUserPostFilter($orders, $request, $validated);
        $this->addProductPostFilter($orders, $request, $validated, true);

        if ($request->has('products_count') && $validated['products_count']) {
            $filteredOrders = [];
            foreach ($orders as $order) {
                $productsCount = count(json_decode($order->products));
                if ($productsCount == (int)$validated['products_count']) {
                    array_push($filteredOrders, $order);
                }
            }

            $orders = $this->toCollection($filteredOrders);
        }

        $orders = $this->paginate($orders, $limit);

        return view('admin.order.index')->with(['orders' => $orders]);
    }
}
