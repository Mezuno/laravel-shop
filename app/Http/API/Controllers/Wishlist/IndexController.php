<?php

namespace App\Http\API\Controllers\Wishlist;

use App\Entities\Wishlist\Http\Resources\WishlistResource;
use App\Entities\Wishlist\Models\Wishlist;
use App\Http\API\Requests\Wishlist\IndexRequest;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function __invoke(IndexRequest $request)
    {
        $data = $request->validated();
        $wishlist = Wishlist::where('user_id', $data['user_id'])->with('product')->orderByDesc('id')->paginate(12, ['*'], 'page', $data['page'] ?? 1);
        return WishlistResource::collection($wishlist);
    }
}
