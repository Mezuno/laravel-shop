<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\UpdateRequest;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductTag;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use mysql_xdevapi\Exception;

class UpdateController extends Controller
{
    public function __invoke(UpdateRequest $request, Product $product)
    {
        $data = $request->validated();

        if (isset($data['preview_image'])) {
            $data['preview_image'] = Storage::disk('public')->put('/images/products/', $data['preview_image']);
        }
        if (isset($data['product_images'])) {
            $productImages = $data['product_images'];
            unset($data['product_images']);
        }

        $product->tags()->sync($data['tags'] ?? []);
        unset($data['tags']);

        // Переписать немного (чтобы фиксированно было во вью)
        if (isset($productImages)) {
            foreach ($productImages as $productImage) {
                $currentImages = ProductImage::where('product_id', $product->id)->count();
                if ($currentImages >= 3) continue;

                $productImage = Storage::disk('public')->put('/images/products/', $productImage);
                ProductImage::insert([
                    'file_path' => $productImage,
                    'product_id' => $product->id,
                ]);
            }
        }

        $product->update($data);

        return redirect()->route('product.show', compact('product'));
    }
}
