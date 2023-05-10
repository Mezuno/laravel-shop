<?php

namespace App\Http\Controllers\Main;

use App\Entities\Order\Models\Order;
use App\Entities\Product\Models\Product;
use App\Entities\Review\Models\Review;
use App\Entities\User\Models\User;
use App\Entities\Wishlist\Models\Wishlist;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Mail\TestMail;
use App\Traits\AdminFilterHelperTrait;
use Illuminate\Support\Facades\Mail;

class IndexController extends Controller
{
    use AdminFilterHelperTrait;

    public function __construct(
        private IndexService $service,
    ) {
    }

    public function __invoke()
    {
//        Mail::to('mekishido@gmail.com')->send(new TestMail());

        $orders = Order::all();

        $mostPopularProductsCount = $this->service->getMostPopularProductsCount($orders);
        $mostPopularProducts = $this->service->getMostPopularProducts($mostPopularProductsCount);
        $ordersPerDayCount = $this->service->getOrdersPerDayCount($orders);
        $lastOrders = $this->service->getLastOrders(5);

        $wishlist = Wishlist::all();

        $mostPopularWishesCount = $this->service->getMostPopularWishesCount($wishlist);
        $mostPopularWishes = $this->service->getMostPopularWishesProducts($mostPopularWishesCount);

        $dataCount = [
            'usersCount' => User::all()->count(),
            'productsCount' => Product::all()->count(),
            'ordersCount' => Order::all()->count(),
            'reviewsCount' => Review::all()->count(),
        ];

        return view('admin.main.index', compact(
            'mostPopularProductsCount',
            'mostPopularProducts',
            'ordersPerDayCount',
            'lastOrders',
            'mostPopularWishesCount',
            'mostPopularWishes',
            'dataCount'));
    }
}
