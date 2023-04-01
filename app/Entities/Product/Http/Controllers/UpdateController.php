<?php

namespace App\Entities\Product\Http\Controllers;

use App\Entities\Product\Http\Requests\UpdateRequest;
use App\Entities\Product\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

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

        if (isset($data['is_published'])) {
            $data['is_published'] = 1;
        } else {
            $data['is_published'] = 0;
        }

        $product->update($data);

        return redirect()->route('product.show', compact('product'))->with(['success' => 'Товар с артикулом ' . $product->vendor_code . ' успешно обновлен']);
    }
}
