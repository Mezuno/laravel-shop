<?php

namespace App\Http\Controllers\Main;

use App\Entities\Order\Models\Order;
use App\Entities\Product\Models\Product;
use App\Entities\Review\Models\Review;
use App\Entities\User\Models\User;
use App\Http\Controllers\Controller;
use App\Traits\AdminFilterHelperTrait;

class IndexController extends Controller
{
    use AdminFilterHelperTrait;

    public function __invoke()
    {
        $orders = Order::all();

        $mostPopularProductsCount = [];

        foreach ($orders as $order) {
            foreach (json_decode($order->products) as $product) {
                $mostPopularProductsCount[] = $product->id;
            }
        }

        $mostPopularProductsCount = array_count_values($mostPopularProductsCount);
        arsort($mostPopularProductsCount);
        $mostPopularProductsCount = array_slice($mostPopularProductsCount, 0, 3, true);
        $mostPopularProducts = [];

        foreach ($mostPopularProductsCount as $id => $count) {
            $mostPopularProducts[] = Product::where('id', '=', $id)->get()->first();
        }


        $orders = Order::all();

        $ordersPerDayCount = [];

        foreach ($orders as $order) {
            if ($order->created_at->format('m') == now()->month) {
                $ordersPerDayCount[] = $order->created_at->format('d');
            }
        }
        $ordersPerDayCount = array_count_values($ordersPerDayCount);
        ksort($ordersPerDayCount);

        $dataCount = [
            'usersCount' => User::all()->count(),
            'productsCount' => Product::all()->count(),
            'ordersCount' => Order::all()->count(),
            'reviewsCount' => Review::all()->count(),
        ];

        return view('admin.main.index', compact('dataCount', 'mostPopularProducts', 'mostPopularProductsCount', 'ordersPerDayCount'));
    }
}
