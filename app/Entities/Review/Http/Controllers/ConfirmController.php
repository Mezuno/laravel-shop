<?php

namespace App\Entities\Review\Http\Controllers;

use App\Entities\Review\Models\Review;
use App\Http\Controllers\Controller;

class ConfirmController extends Controller
{
    public function __invoke(Review $review)
    {
        $review->update(['confirmed_at' => now()]);
        return redirect()->route('review.index')->with(['success' => 'Отзыв id' . $review->id . ' успешно подтвержден']);
    }
}
