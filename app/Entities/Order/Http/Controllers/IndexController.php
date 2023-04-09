<?php

namespace App\Entities\Order\Http\Controllers;

use App\Entities\Order\Http\Requests\IndexRequest;
use App\Entities\Order\Models\Order;
use App\Entities\User\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class IndexController extends Controller
{
    public function __invoke(IndexRequest $request)
    {
        $query = Order::query();

        $validated = $request->validated();

        if (!$validated) {
            $orders = $query->with('orderer')->orderByDesc('id')->get();
            $limit = 8;
            $orders = $this->paginate($orders, $limit);
            return view('admin.order.index')->with(['orders' => $orders]);
        }

        if ($request->has('price_from') && $validated['price_from']) {
            $query->where('total_price', '>=', $validated['price_from']);
        }

        if ($request->has('price_to') && $validated['price_to']) {
            $query->where('total_price', '<=', $validated['price_to']);
        }

        if (!$request->has('payment_status_true')) {
            $validated['payment_status_true'] = null;
        }
        if (!$request->has('payment_status_false')) {
            $validated['payment_status_false'] = null;
        }

        if ($request->has('payment_status_true') && $validated['payment_status_true']) {
            if ($validated['payment_status_true'] == 'on' && $validated['payment_status_false'] != 'on') {
                $payment_status = 1;
                $query->where('payment_status', '=', $payment_status);
            }
        }

        if ($request->has('payment_status_false') && $validated['payment_status_false']) {
            if ($validated['payment_status_false'] == 'on' && $validated['payment_status_true'] != 'on') {
                $payment_status = 0;
                $query->where('payment_status', '=', $payment_status);
            }
        }

        if ($request->has('size') && $validated['size']) {
            if ((int)$validated['size'] <= 0) {
                $limit = 8;
            } else {
                $limit = (int)$validated['size'];
            }
        } else {
            $limit = 8;
        }

        $orders = $query->withTrashed()->with('orderer')->orderByDesc('id')->get();

        if ($request->has('user') && $validated['user']) {
            $filteredOrders = [];
            foreach ($orders as $order) {
                if ($this->likeMatch('%'.$validated['user'].'%', $order->orderer->name)) {
                    array_push($filteredOrders, $order);
                }
                elseif ($this->likeMatch('%'.$validated['user'].'%', $order->orderer->email)) {
                    array_push($filteredOrders, $order);
                }
                elseif ($this->likeMatch('%'.$validated['user'].'%', $order->orderer->id)) {
                    array_push($filteredOrders, $order);
                }
            }

            $orders = $this->toCollection($filteredOrders);
        }

        if ($request->has('product') && $validated['product']) {
            $filteredOrders = [];
            foreach ($orders as $order) {
                foreach (json_decode($order->products) as $product) {
                    if ($product->vendor_code === (int)$validated['product']) {
                        array_push($filteredOrders, $order);
                    }
                    elseif ($this->likeMatch('%'.$validated['product'].'%', $product->title)) {
                        array_push($filteredOrders, $order);
                    }
                }
            }

            $orders = $this->toCollection($filteredOrders);
        }

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
