<?php

namespace App\Http\API\Controllers\Wishlist;

use App\Entities\Wishlist\Http\Resources\WishlistResource;
use App\Entities\Wishlist\Models\Wishlist;
use App\Http\API\Requests\Wishlist\StoreRequest;
use App\Http\Controllers\Controller;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request)
    {
        $data = $request->validated();

        $wish = Wishlist::create([
            'user_id' => $data['user_id'],
            'product_id' => $data['product_id'],
        ]);

        return new WishlistResource($wish);
    }
}
