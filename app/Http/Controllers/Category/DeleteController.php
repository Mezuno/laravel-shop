<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

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
