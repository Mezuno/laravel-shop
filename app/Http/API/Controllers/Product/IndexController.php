<?php

namespace App\Http\API\Controllers\Product;

use App\Entities\Product\Http\Filters\ProductFilter;
use App\Entities\Product\Http\Resources\ProductResource;
use App\Entities\Product\Models\Product;
use App\Http\API\Requests\Product\IndexRequest;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function __invoke()
    {
        $products = Product::where('is_published', 1)->orderByDesc('id')->get();
        return ProductResource::collection($products);
    }
}
