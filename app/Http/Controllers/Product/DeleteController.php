<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;

class DeleteController extends Controller
{
    public function __invoke(Product $product)
    {
        $product->delete();
        return redirect()->route('product.index')->with(['success' => 'Товар с артикулом ' . $product->vendor_code . ' успешно удален']);
    }
}
