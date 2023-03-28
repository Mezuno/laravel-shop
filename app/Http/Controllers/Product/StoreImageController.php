<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreImageRequest;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Storage;

class StoreImageController extends Controller
{
    public function __invoke(StoreImageRequest $request, Product $product)
    {
        $data = $request->validated();

        $data['product_image'] = Storage::disk('public')->put('/images/products/', $data['product_image']);
        ProductImage::insert([
            'file_path' => $data['product_image'],
            'product_id' => $product->id,
        ]);

        return redirect()->route('product.edit', $product->id);
    }
}
