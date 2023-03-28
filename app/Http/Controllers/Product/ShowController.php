<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ShowController extends Controller
{
    public function __invoke(Product $product)
    {
        $product = $product->where('id', $product->id)->with('category')->with('tags')->first();
        return view('product.show', compact('product'));
    }
}
