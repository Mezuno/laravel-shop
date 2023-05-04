<?php

namespace App\Http\API\Controllers\Order;

use App\Entities\Order\Http\Resources\OrderResource;
use App\Entities\Order\Models\Order;
use App\Entities\User\Models\User;
use App\Http\API\Requests\Order\StoreRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request)
    {
        $data = $request->validated();

        $data['password'] = Hash::make('password');

        $user = User::firstOrCreate([
            'email' => $data['email']
        ],[
            'name' => $data['name'],
            'address' => $data['address'],
            'password' => $data['password'],
        ]);

        $order = Order::create([
            'products' => json_encode($data['products']),
            'user_id' => $user->id,
            'total_price' => $data['total_price'],
            'payment_status' => 0,
            'status' => 0,
            'address' => $data['address'],
        ]);

        return new OrderResource($order);
    }
}
