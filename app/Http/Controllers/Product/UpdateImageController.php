<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\UpdateImageRequest;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Storage;

class UpdateImageController extends Controller
{
    public function __invoke(UpdateImageRequest $request, Product $product, ProductImage $productImage)
    {
        $data = $request->validated();

        $data['product_image'] = Storage::disk('public')->put('/images/products', $data['product_image']);

        Storage::disk('public')->delete($productImage->file_path);
        $productImage->file_path = $data['product_image'];
        $productImage->save();

        return redirect()->route('product.edit', $product->id);
    }
}
