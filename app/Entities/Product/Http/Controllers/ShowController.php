<?php

namespace App\Entities\Product\Http\Controllers;

use App\Entities\Product\Models\Product;
use App\Entities\Product\Models\ProductImage;
use App\Http\Controllers\Controller;

class ShowController extends Controller
{
    public function __invoke(int $productId)
    {
        $product = Product::withTrashed()->where('id', $productId)->with('category')->with('tags')->first();
        $productImages = ProductImage::where('product_id', $productId)->get();
        return view('admin.product.show', compact('product', 'productImages'));
    }
}
