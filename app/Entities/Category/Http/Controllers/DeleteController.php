<?php

namespace App\Entities\Category\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Entities\Category\Models\Category;
use App\Entities\Product\Models\Product;

class DeleteController extends Controller
{
    public function __invoke(Category $category)
    {
        $product = Product::where('category_id', $category->id)->get()->first();
        if ($product) {
            return back()->with(['error' => 'Категория id' . $category->id . ' привязана к товару, поэтому не может быть удалена']);
        }
        $category->delete();
        return redirect()->route('category.index')->with(['success' => 'Категория id' . $category->id . ' успешно удалена']);
    }
}
