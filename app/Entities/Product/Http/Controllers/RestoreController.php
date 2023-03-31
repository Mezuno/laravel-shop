<?php

namespace App\Entities\Product\Http\Controllers;

use App\Entities\Product\Models\Product;
use App\Http\Controllers\Controller;

class RestoreController extends Controller
{
    public function __invoke(int $productId)
    {
        Product::withTrashed()->find($productId)->update(['deleted_at' => null]);

        $product = Product::find($productId);

        return redirect()->route('product.show', compact('product'))->with(['success' => 'Товар с артикулом ' . $product->vendor_code . ' успешно восстановлен']);
    }
}
