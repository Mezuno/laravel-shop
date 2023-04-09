<?php

namespace App\Entities\Review\Http\Controllers;

use App\Entities\Review\Models\Review;
use App\Http\Controllers\Controller;

class RestoreController extends Controller
{
    public function __invoke(int $reviewId)
    {
        Review::withTrashed()->where('id', '=', $reviewId)->update(['deleted_at' => null]);
        $review = Review::find($reviewId);
        return redirect()->route('review.index')->with(['success' => 'Отзыв id' . $review->id . ' успешно восстановлен']);
    }
}
