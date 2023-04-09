<?php

namespace App\Http\Controllers\Main;

use App\Entities\Order\Models\Order;
use App\Entities\Product\Models\Product;
use App\Entities\Review\Models\Review;
use App\Entities\User\Models\User;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function __invoke()
    {
        $data = [
            'usersCount' => User::all()->count(),
            'productsCount' => Product::all()->count(),
            'ordersCount' => Order::all()->count(),
            'reviewsCount' => Review::all()->count(),
        ];
        return view('admin.main.index', compact('data'));
    }
}
