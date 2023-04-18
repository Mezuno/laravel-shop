<?php

namespace App\Http\Controllers\Main;

use App\Entities\Order\Models\Order;
use App\Entities\Product\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class IndexService
{
    public function getMostPopularProductsCount(Collection $orders): array
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
        return array_slice($mostPopularProductsCount, 0, 3, true);
    }

    public function getMostPopularProducts(array $mostPopularProductsCount): array
    {
        $mostPopularProducts = [];

        foreach ($mostPopularProductsCount as $id => $count) {
            $mostPopularProducts[] = Product::withTrashed()->where('id', '=', $id)->get()->first();
        }

        return $mostPopularProducts;
    }

    public function getOrdersPerDayCount(Collection $orders): array
    {
        $ordersPerDayCount = [];

        foreach ($orders as $order) {
            if ($order->created_at->format('m') == now()->month) {
                $ordersPerDayCount[] = $order->created_at->format('d');
            }
        }
        $ordersPerDayCount = array_count_values($ordersPerDayCount);
        ksort($ordersPerDayCount);

        return $ordersPerDayCount;
    }

    public function getMostPopularWishesCount(Collection $wishlist): array
    {
        $mostPopularWishesCount = [];

        foreach ($wishlist as $wish) {
            $mostPopularWishesCount[] = $wish->product_id;
        }

        $mostPopularWishesCount = array_count_values($mostPopularWishesCount);
        arsort($mostPopularWishesCount);

        return array_slice($mostPopularWishesCount, 0, 3, true);
    }

    public function getMostPopularWishesProducts(array $mostPopularWishesCount): array
    {
        $mostPopularWishes = [];

        foreach ($mostPopularWishesCount as $id => $count) {
            $mostPopularWishes[] = Product::withTrashed()->where('id', '=', $id)->get()->first();
        }

        return $mostPopularWishes;
    }

    public function getLastOrders(int $size)
    {
        return Order::where('id', '>', 0)->orderByDesc('id')->take($size)->get();
    }
}
