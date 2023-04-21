<?php

namespace App\Http\API\Controllers\Review;

use App\Entities\Review\Models\Review;
use App\Entities\Review\Http\Resources\ReviewResource;
use App\Http\API\Requests\Review\CheckRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class CheckController extends Controller
{
    public function __invoke(CheckRequest $request)
    {
        $data = $request->validated();

        $review = Review::where('user_id', $data['user_id'])->where('product_id', $data['product_id'])->first();

        if (!$review) {
//            return new Response('Отзыва нету', 404);
            return 1;
        }

        return new ReviewResource($review);
    }
}
