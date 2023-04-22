<?php

namespace App\Http\API\Controllers\Product;

use App\Entities\Product\Http\Resources\ProductResource;
use App\Entities\Product\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class ShowController extends Controller
{
    public function __invoke(Product $product)
    {
        if (!$product->published_at) {
            return new Response('Товар не существует или не опубликован', 404);
        }
        return new ProductResource($product);
    }
}
