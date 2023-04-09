<?php

namespace App\Entities\Product\Http\Controllers;

use App\Entities\Product\Http\Requests\MassDeleteRequest;
use App\Entities\Product\Models\Product;
use App\Http\Controllers\Controller;

class MassDeleteController extends Controller
{
    public function __invoke(MassDeleteRequest $request)
    {
        $data = $request->validated();

        Product::whereIn('id', $data['products_ids'])->delete();

        $response = implode(', ', $data['products_ids']);

        return redirect()->route('product.index')->with(['success' => 'Товары с id ' . $response . ' успешно удалены']);
    }
}
