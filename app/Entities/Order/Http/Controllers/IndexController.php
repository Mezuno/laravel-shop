<?php

namespace App\Entities\Order\Http\Controllers;

use App\Entities\Order\Models\Order;
use App\Entities\User\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class IndexController extends Controller
{
    public function __invoke(Request $request)
    {
        $query = Order::query();

        if ($request->has('price_from') && $request->get('price_from') != null) {
            $query->where('total_price', '>=', $request->get('price_from'));
        }
        if ($request->has('price_to') && $request->get('price_to') != null) {
            $query->where('total_price', '<=', $request->get('price_to'));
        }
        if ($request->has('payment_status_true') && $request->get('payment_status_true') != null) {
            if ($request->get('payment_status_true') == 'on' && $request->get('payment_status_false') != 'on') {
                $payment_status = 1;
                $query->where('payment_status', '=', $payment_status);
            }
        }
        if ($request->has('payment_status_false') && $request->get('payment_status_false') != null) {
            if ($request->get('payment_status_false') == 'on' && $request->get('payment_status_true') != 'on') {
                $payment_status = 0;
                $query->where('payment_status', '=', $payment_status);
            }
        }
        if ($request->has('size')) {
            if ((int)$request->get('size') <= 0) {
                $limit = 8;
            } else {
                $limit = (int)$request->get('size');
            }
        } else {
            $limit = 8;
        }

        $orders = $query->withTrashed()->with('orderer')->orderByDesc('id')->get();

        if ($request->has('user') && $request->get('user') != null) {
            $filteredOrders = [];
            foreach ($orders as $order) {
                if ($this->likeMatch('%'.$request->get('user').'%', $order->orderer->name)) {
                    array_push($filteredOrders, $order);
                }
                elseif ($this->likeMatch('%'.$request->get('user').'%', $order->orderer->email)) {
                    array_push($filteredOrders, $order);
                }
                elseif ($this->likeMatch('%'.$request->get('user').'%', $order->orderer->id)) {
                    array_push($filteredOrders, $order);
                }
            }

            $orders = $this->toCollection($filteredOrders);
        }

        if ($request->has('product') && $request->get('product') != null) {
            $filteredOrders = [];
            foreach ($orders as $order) {
                foreach (json_decode($order->products) as $product) {
                    if ($product->vendor_code === (int)$request->get('product')) {
                        array_push($filteredOrders, $order);
                    }
                    elseif ($this->likeMatch('%'.$request->get('product').'%', $product->title)) {
                        array_push($filteredOrders, $order);
                    }
                }
            }

            $orders = $this->toCollection($filteredOrders);
        }

        if ($request->has('products_count') && $request->get('products_count') != null) {
            $filteredOrders = [];
            foreach ($orders as $order) {
                $productsCount = count(json_decode($order->products));
                if ($productsCount == (int)$request->get('products_count')) {
                    array_push($filteredOrders, $order);
                }
            }

            $orders = $this->toCollection($filteredOrders);
        }

        $orders = $this->paginate($orders, $limit);

        return view('admin.order.index')->with(['orders' => $orders]);
    }

    private function likeMatch($pattern, $subject): bool
    {
        $pattern = str_replace('%', '.*', preg_quote($pattern, '/'));
        return (bool) preg_match("/^{$pattern}$/i", $subject);
    }

    private function toCollection(array $orders): Collection
    {
        $collectionOrders = new Collection();
        foreach($orders as $order){
            $collectionOrders->push((object)$order);
        }
        return $collectionOrders;
    }

    private function paginate($items, $perPage = 15, $page = null, $options = []): LengthAwarePaginator
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);

        $items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
