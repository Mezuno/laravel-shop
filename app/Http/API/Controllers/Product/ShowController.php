<?php

namespace App\Http\API\Controllers\Product;

use App\Entities\Product\Http\Resources\ProductResource;
use App\Entities\Product\Models\Product;
use App\Http\Controllers\Controller;

class ShowController extends Controller
{
    public function __invoke(Product $product)
    {
        return new ProductResource($product);
    }
}
