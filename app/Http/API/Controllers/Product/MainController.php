<?php

namespace App\Http\API\Controllers\Product;

use App\Entities\Product\Http\Resources\ProductResource;
use App\Entities\Product\Models\Product;

class MainController
{
    public function __invoke()
    {
        $products = Product::where('is_published', 1)->orderByDesc('id')->take(10)->get();
        return ProductResource::collection($products);
    }
}
