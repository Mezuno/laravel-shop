<?php

namespace App\Entities\Product\Http\Controllers;

use App\Entities\Product\Http\Requests\MassPublishRequest;
use App\Entities\Product\Models\Product;
use App\Http\Controllers\Controller;

class MassPublishController extends Controller
{
    public function __invoke(MassPublishRequest $request)
    {
        $data = $request->validated();

        Product::whereIn('id', $data['products_ids'])->update(['is_published' => 1]);

        $response = implode(', ', $data['products_ids']);

        return redirect()->route('product.index')->with(['success' => 'Товары с id ' . $response . ' успешно опубликованы']);
    }
}
