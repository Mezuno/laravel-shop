<?php

namespace App\Entities\Product\Http\Controllers;

use App\Entities\Category\Models\Category;
use App\Entities\Product\Models\Product;
use App\Entities\Product\Models\ProductImage;
use App\Entities\Tag\Models\Tag;
use App\Http\Controllers\Controller;

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
        return view('admin.product.edit', compact('product', 'categories', 'tags', 'productImages', 'productImagesCount'));
    }
}
