<?php

namespace App\Entities\Product\Http\Controllers;

use App\Entities\Product\Http\Requests\StoreImageRequest;
use App\Entities\Product\Models\Product;
use App\Entities\Product\Models\ProductImage;
use App\Http\Controllers\Controller;
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
