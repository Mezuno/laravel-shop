<?php

namespace App\Entities\Product\Http\Controllers;

use App\Entities\Product\Models\Product;
use App\Entities\Product\Models\ProductImage;
use App\Entities\Product\Models\ProductTag;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Entities\Product\Http\Requests\StoreRequest;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request)
    {
        $data = $request->validated();

        $data['preview_image'] = Storage::disk('public')->put('/images/products/', $data['preview_image']);

        if (isset($data['tags'])) {
            $tagsIds = $data['tags'];
            unset($data['tags']);
        }

        $data['vendor_code'] = Product::withTrashed()->max('vendor_code')+1;

        if (isset($data['product_images'])) {
            $productImages = $data['product_images'];
            unset($data['product_images']);
        }

        $product = Product::firstOrCreate([
            'vendor_code' => $data['vendor_code']
        ], $data);


        if (isset($productImages)) {
            foreach ($productImages as $productImage) {
                $productImage = Storage::disk('public')->put('/images/products/', $productImage);
                $currentImages = ProductImage::where('product_id', $product->id)->count();
                ProductImage::insert([
                    'file_path' => $productImage,
                    'product_id' => $product->id,
                ]);
            }
        }

        if (isset($tagsIds)) {
            foreach ($tagsIds as $tagsId) {
                ProductTag::firstOrCreate([
                    'product_id' => $product->id,
                    'tag_id' => $tagsId,
                ]);
            }
        }
        return redirect()->route('product.index');
    }
}
