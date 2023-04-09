<?php

namespace App\Entities\Review\Http\Controllers;

use App\Entities\Review\Http\Requests\IndexRequest;
use App\Entities\Review\Models\Review;
use App\Http\Controllers\Controller;
use App\Traits\AdminFilterHelperTrait;

class IndexController extends Controller
{
    use AdminFilterHelperTrait;

    public function __invoke(IndexRequest $request)
    {
        $query = Review::query();

        $validated = $request->validated();

        $limit = $this->getFilterSize($request, $validated);

        if (!$validated) {
            $reviews = $query->with('user')->with('product')->orderByDesc('id')->paginate($limit);
            return view('admin.review.index')->with(['reviews' => $reviews]);
        }

        $this->addWhereFilterToQuery($query, $request, $validated, 'title', 'like', true);
        $this->addWhereBoolFilterToQuery($query, $request, $validated, 'confirmed_at', true);
        $this->addWhereBetweenFilterToQuery($query, $request, $validated, 'rate', 1, 5);
        $this->addWithTrashedFilterToQuery($query, $request, $validated);

        $reviews = $query->with('user')->with('product')->orderByDesc('id')->get();

        $this->addUserPostFilter($reviews, $request, $validated);
        $this->addProductPostFilter($reviews, $request, $validated);

        $reviews = $this->paginate($reviews, $limit, null, ['path' => 'http://localhost:8000/admin/reviews']);

        return view('admin.review.index')->with(['reviews' => $reviews]);
    }
}
