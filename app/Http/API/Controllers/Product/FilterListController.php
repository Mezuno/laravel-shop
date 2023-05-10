<?php

namespace App\Http\API\Controllers\Product;

use App\Entities\Category\Models\Category;
use App\Entities\Product\Models\Product;
use App\Entities\Tag\Models\Tag;
use App\Http\Controllers\Controller;

class FilterListController extends Controller
{
    public function __invoke()
    {
        $categories = Category::all();
        $tags = Tag::all();

        $maxPrice = Product::orderBy('price', 'DESC')->first()->price;
        $minPrice = Product::orderBy('price', 'ASC')->first()->price;

        $result = [
            'categories' => $categories,
            'tags' => $tags,
            'price' => [
                'min' => $minPrice,
                'max' => $maxPrice,
            ],
        ];

        return response()->json($result);
    }
}
