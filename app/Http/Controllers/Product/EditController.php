<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Tag;

class EditController extends Controller
{
    public function __invoke(Product $product)
    {
        $product = $product->where('id', $product->id)->with('tags')->first();
        $tags = Tag::all();
        $categories = Category::all();
        $productImages = ProductImage::where('product_id', $product->id)->get();
        if ($productImages) {
            $productImagesCount = count($productImages);
        } else {
            $productImagesCount = 0;
        }
        return view('product.edit', compact('product', 'categories', 'tags', 'productImages', 'productImagesCount'));
    }
}
