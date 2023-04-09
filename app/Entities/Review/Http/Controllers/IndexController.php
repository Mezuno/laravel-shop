<?php

namespace App\Entities\Review\Http\Controllers;

use App\Entities\Review\Http\Requests\IndexRequest;
use App\Entities\Review\Models\Review;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class IndexController extends Controller
{
    public function __invoke(IndexRequest $request)
    {
        $query = Review::query();

        $validated = $request->validated();

        if (!$validated) {
            $limit = 8;
            $reviews = $query->with('user')->with('product')->orderByDesc('id')->paginate($limit);
            return view('admin.review.index')->with(['reviews' => $reviews]);
        }

        if ($request->has('title') && $validated['title']) {
            $query->where('title', 'like', '%'.$validated['title'].'%');
        }

        if (!$request->has('confirmed_true')) {
            $validated['confirmed_true'] = null;
        }
        if (!$request->has('confirmed_false')) {
            $validated['confirmed_false'] = null;
        }

        if ($request->has('confirmed_true') && $validated['confirmed_true']) {
            if ($validated['confirmed_true'] == 'on' && $validated['confirmed_false'] != 'on') {
                $query->where('confirmed_at', '!=', null);
            }
        }

        if ($request->has('confirmed_false') && $validated['confirmed_false']) {
            if ($validated['confirmed_false'] == 'on' && $validated['confirmed_true'] != 'on') {
                $query->where('confirmed_at', '=', null);
            }
        }

        if ($validated['rate_from']) {
            if ($validated['rate_from'] < 1) {
                $rateFrom = 1;
            } else {
                $rateFrom = (int)$validated['rate_from'];
            }
        } else {
            $rateFrom = 1;
        }

        if ($validated['rate_to']) {
            if ($validated['rate_to'] > 5 || $validated['rate_to'] == '') {
                $rateTo = 5;
            } else {
                $rateTo = (int)$validated['rate_to'];
            }
        } else {
            $rateTo = 5;
        }

        if ($validated['size']) {
            if ((int)$validated['size'] <= 0) {
                $limit = 8;
            } else {
                $limit = (int)$validated['size'];
            }
        } else {
            $limit = 8;
        }

        if (!$request->has('deleted')) {
            $validated['deleted'] = null;
        }
        if ($validated['deleted']) {
            $query->withTrashed();
        }

        $reviews = $query->whereBetween('rate', [$rateFrom, $rateTo])->with('user')->with('product')->orderByDesc('id')->get();

        if ($request->has('user') && $validated['user']) {
            $filteredReviews = [];
            foreach ($reviews as $review) {
                if ($this->likeMatch('%'.$validated['user'].'%', $review->user->name) or
                    $this->likeMatch('%'.$validated['user'].'%', $review->user->email) or
                    $this->likeMatch('%'.$validated['user'].'%', $review->user->id)) {
                    array_push($filteredReviews, $review);
                }
            }

            $reviews = $this->toCollection($filteredReviews);
        }

        if ($request->has('product') && $validated['product']) {
            $filteredReviews = [];
            foreach ($reviews as $review) {
                if ($review->product->vendor_code === (int)$validated['product'] or
                    $this->likeMatch('%'.$validated['product'].'%', $review->product->title)) {
                    array_push($filteredReviews, $review);
                }
            }

            $reviews = $this->toCollection($filteredReviews);
        }

        $reviews = $this->paginate($reviews, $limit);

        return view('admin.review.index')->with(['reviews' => $reviews]);
    }

    private function likeMatch($pattern, $subject): bool
    {
        $pattern = str_replace('%', '.*', preg_quote($pattern, '/'));
        return (bool) preg_match("/^{$pattern}$/i", $subject);
    }

    private function toCollection(array $array): Collection
    {
        $collection = new Collection();
        foreach($array as $item){
            $collection->push((object)$item);
        }
        return $collection;
    }

    private function paginate($items, $perPage = 15, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);

        $items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
