<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreRequest;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductTag;
use Illuminate\Support\Facades\Storage;

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

        $data['vendor_code'] = Product::whereRaw('vendor_code = (select max(`vendor_code`) from products)')->get()->first()->vendor_code+1;

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
                dd($currentImages);
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
