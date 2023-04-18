<?php

namespace App\Http\API\Controllers\Review;

use App\Entities\Review\Models\Review;
use App\Entities\Review\Http\Resources\ReviewResource;
use App\Http\API\Requests\Review\IndexRequest;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function __invoke(IndexRequest $request)
    {
        $data = $request->validated();
        $wishlist = Review::where('confirmed_at', '!=', null)
            ->where('product_id', '=', $data['product_id'])
            ->orderByDesc('id')
            ->paginate(12, ['*'], 'page', $data['page'] ?? 1);

        return ReviewResource::collection($wishlist);
    }
}
