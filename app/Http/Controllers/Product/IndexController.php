<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __invoke(Request $request)
    {
        $query = Product::query();

        if ($request->has('title') && $request->get('title') != null) {
            $query->where('title', 'like', '%'.$request->get('title').'%');
        }
        if ($request->has('vendor_code') && $request->get('vendor_code') != null) {
            $query->where('vendor_code', '=', $request->get('vendor_code'));
        }
        if ($request->has('description') && $request->get('description') != null) {
            $query->where('description', 'like', '%'.$request->get('description').'%');
        }
        if ($request->has('content') && $request->get('content') != null) {
            $query->where('content', 'like', '%'.$request->get('content').'%');
        }
        if ($request->has('price_from') && $request->get('content') != null) {
            $query->where('price', '>', $request->get('price_from'));
        }
        if ($request->has('price_to') && $request->get('content') != null) {
            $query->where('price', '<', $request->get('price_to'));
        }
        if ($request->has('is_published') && $request->get('is_published') != null) {
            if ($request->get('is_published') == 'on' && $request->get('is_not_published') != 'on') {
                $isPublished = 1;
                $query->where('is_published', '=', $isPublished);
            }
        }
        if ($request->has('is_not_published') && $request->get('is_not_published') != null) {
            if ($request->get('is_not_published') == 'on' && $request->get('is_published') != 'on') {
                $isNotPublished = 0;
                $query->where('is_published', '=', $isNotPublished);
            }
        }
        if ($request->has('price_from') || $request->get('price_from') == '') {
            if ($request->get('price_from') < 0) {
                $priceFrom = 0;
            } else {
                $priceFrom = (int)$request->get('price_from');
            }
        } else {
            $priceFrom = 0;
        }
        if ($request->has('price_to')) {
            if ($request->get('price_to') > 100000 || $request->get('price_to') == '') {
                $priceTo = 100000;
            } else {
                $priceTo = (int)$request->get('price_to');
            }
        } else {
            $priceTo = 100000;
        }
        if ($request->has('size')) {
            if ((int)$request->get('size') <= 0) {
                $limit = 8;
            } else {
                $limit = (int)$request->get('size');
            }
        } else {
            $limit = 8;
        }

        $products = $query->whereBetween('price', [$priceFrom, $priceTo])->with('category')->orderByDesc('id')->paginate($limit);

        return view('admin.product.index')->with(['products' => $products]);
    }
}
