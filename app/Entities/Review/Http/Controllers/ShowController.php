<?php

namespace App\Entities\Review\Http\Controllers;

use App\Entities\Review\Models\Review;
use App\Http\Controllers\Controller;

class ShowController extends Controller
{
    public function __invoke(Review $review)
    {
        return view('admin.review.show')->with(['review' => $review]);
    }
}
