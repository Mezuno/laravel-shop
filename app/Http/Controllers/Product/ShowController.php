<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;

class ShowController extends Controller
{
    public function __invoke(Product $product)
    {
        $product = $product->where('id', $product->id)->with('category')->with('tags')->first();
        $productImages = ProductImage::where('product_id', $product->id)->get();
        return view('admin.product.show', compact('product', 'productImages'));
    }
}
