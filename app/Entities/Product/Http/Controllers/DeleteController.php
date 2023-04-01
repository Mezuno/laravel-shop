<?php

namespace App\Entities\Product\Http\Controllers;

use App\Entities\Product\Models\Product;
use App\Http\Controllers\Controller;

class DeleteController extends Controller
{
    public function __invoke(Product $product)
    {
        $product->delete();
        return redirect()->route('product.index')->with(['success' => 'Товар с артикулом ' . $product->vendor_code . ' успешно удален']);
    }
}
