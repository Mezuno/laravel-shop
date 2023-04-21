<?php

namespace App\Http\API\Controllers\Wishlist;

use App\Entities\User\Models\User;
use App\Entities\Wishlist\Http\Resources\WishlistResource;
use App\Entities\Wishlist\Models\Wishlist;
use App\Http\API\Requests\Wishlist\SyncRequest;
use App\Http\Controllers\Controller;

class SyncController extends Controller
{
    public function __invoke(SyncRequest $request)
    {
        $data = $request->validated();

        $user = User::find($data['user_id']);

        foreach ($data['products'] as $key => $product) {
            unset($data['products'][$key]['product']);
        }

        $user->wishlist()->delete();

        $newWishlist = [];

        foreach ($data['products'] as $key => $product) {
            $newWishlist[] = $user->wishlist()->create([
                'user_id' => $data['user_id'],
                'product_id' => $data['products'][$key]['product_id']
            ]);
        }

        return 1;
    }
}
