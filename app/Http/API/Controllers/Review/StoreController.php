<?php

namespace App\Http\API\Controllers\Review;

use App\Entities\Review\Models\Review;
use App\Entities\Review\Http\Resources\ReviewResource;
use App\Http\API\Requests\Review\StoreRequest;
use App\Http\Controllers\Controller;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request)
    {
        $data = $request->validated();

        if (!isset($data['advantages'])) {
            $data['advantages'] = null;
        }
        if (!isset($data['flaws'])) {
            $data['flaws'] = null;
        }

        $review = Review::create([
            'user_id' => $data['user_id'],
            'product_id' => $data['product_id'],
            'title' => $data['title'],
            'rate' => $data['rate'],
            'advantages' => $data['advantages'],
            'flaws' => $data['flaws'],
            'body' => $data['body'],
        ]);

        return new ReviewResource($review);
    }
}
