<?php

namespace App\Http\API\Controllers\Product;

use App\Entities\Product\Http\Resources\ProductResource;
use App\Entities\Product\Models\Product;
use App\Traits\AdminFilterHelperTrait;

class MainController
{
    use AdminFilterHelperTrait;

    public function __invoke()
    {
        $products = Product::where('is_published', 1)->orderByDesc('id')->get();

        foreach ($products as $key => $product) {
            if (round($product->review()->avg('rate')) < 4) {
                $products->forget($key);
            }
        }

        $products = $this->paginate($products, 12);

        return ProductResource::collection($products);
    }
}
