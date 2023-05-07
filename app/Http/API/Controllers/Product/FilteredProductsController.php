<?php

namespace App\Http\API\Controllers\Product;

use App\Entities\Product\Http\Filters\ProductFilter;
use App\Entities\Product\Http\Resources\ProductResource;
use App\Entities\Product\Models\Product;
use App\Http\API\Requests\Product\IndexRequest;

class FilteredProductsController
{
    public function __invoke(IndexRequest $request)
    {
        $data = $request->validated();
        $filter = app()->make(ProductFilter::class, ['queryParams' => array_filter($data)]);
        $products = Product::filter($filter)->where('is_published', 1)->orderByDesc('id')->paginate(12, ['*'], 'page', $data['page']);
        return ProductResource::collection($products);
    }
}
