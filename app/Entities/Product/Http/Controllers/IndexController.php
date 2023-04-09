<?php

namespace App\Entities\Product\Http\Controllers;

use App\Entities\Product\Http\Requests\IndexRequest;
use App\Entities\Product\Models\Product;
use App\Http\Controllers\Controller;
use App\Traits\AdminFilterHelperTrait;

class IndexController extends Controller
{
    use AdminFilterHelperTrait;

    public function __invoke(IndexRequest $request)
    {
        $query = Product::query();

        $validated = $request->validated();

        $limit = $this->getFilterSize($request, $validated);

        if (!$validated) {
            $products = $query->with('category')->orderByDesc('id')->paginate($limit);
            return view('admin.product.index')->with(['products' => $products]);
        }

        $this->addWhereFilterToQuery($query, $request, $validated, 'title', 'like', true);
        $this->addWhereFilterToQuery($query, $request, $validated, 'vendor_code', '=', false);
        $this->addWhereFilterToQuery($query, $request, $validated, 'description', 'like', true);
        $this->addWhereFilterToQuery($query, $request, $validated, 'content', 'like', true);
        $this->addWhereBoolFilterToQuery($query, $request, $validated, 'is_published');
        $this->addWhereBetweenFilterToQuery($query, $request, $validated, 'price', 1, 100000);
        $this->addWithTrashedFilterToQuery($query, $request, $validated);

        $products = $query->with('category')->orderByDesc('id')->paginate($limit);

        return view('admin.product.index')->with(['products' => $products]);
    }
}
