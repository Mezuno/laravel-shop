<?php

namespace App\Entities\Product\Http\Controllers;

use App\Entities\Product\Http\Requests\UpdateImageRequest;
use App\Entities\Product\Models\Product;
use App\Entities\Product\Models\ProductImage;
use App\Http\Controllers\Controller;
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
