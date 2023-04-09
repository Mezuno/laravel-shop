<?php

namespace App\Entities\Product\Http\Controllers;

use App\Entities\Product\Http\Requests\IndexRequest;
use App\Entities\Product\Models\Product;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function __invoke(IndexRequest $request)
    {
        $query = Product::query();

        $validated = $request->validated();

        if (!$validated) {
            $limit = 8;
            $products = $query->with('category')->orderByDesc('id')->paginate($limit);
            return view('admin.product.index')->with(['products' => $products]);
        }

        if ($request->has('title') && $validated['title']) {
            $query->where('title', 'like', '%'.$validated['title'].'%');
        }

        if ($request->has('vendor_code') && $validated['vendor_code']) {
            $query->where('vendor_code', '=', $validated['vendor_code']);
        }

        if ($request->has('description') && $validated['description']) {
            $query->where('description', 'like', '%'.$validated['description'].'%');
        }

        if ($request->has('content') && $validated['content']) {
            $query->where('content', 'like', '%'.$validated['content'].'%');
        }

        if (!$request->has('is_published')) {
            $validated['is_published'] = null;
        }
        if (!$request->has('is_not_published')) {
            $validated['is_not_published'] = null;
        }

        if ($validated['is_published']) {
            if ($validated['is_published'] == 'on' && $validated['is_not_published'] != 'on') {
                $isPublished = 1;
                $query->where('is_published', '=', $isPublished);
            }
        }

        if ($validated['is_not_published']) {
            if ($validated['is_not_published'] == 'on' && $validated['is_published'] != 'on') {
                $isNotPublished = 0;
                $query->where('is_published', '=', $isNotPublished);
            }
        }

        if ($request->has('price_from') && $validated['price_from']) {
            if ($validated['price_from'] < 0) {
                $priceFrom = 0;
            } else {
                $priceFrom = (int)$validated['price_from'];
            }
        } else {
            $priceFrom = 0;
        }

        if ($request->has('price_to') && $validated['price_to']) {
            if ($validated['price_to'] > 100000 || $validated['price_to'] == '') {
                $priceTo = 100000;
            } else {
                $priceTo = (int)$validated['price_to'];
            }
        } else {
            $priceTo = 100000;
        }

        if ($request->has('size') && $validated['size']) {
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

        $products = $query->whereBetween('price', [$priceFrom, $priceTo])->with('category')->orderByDesc('id')->paginate($limit);

        return view('admin.product.index')->with(['products' => $products]);
    }
}
