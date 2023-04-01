<?php

namespace App\Entities\Category\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Entities\Category\Models\Category;

class IndexController extends Controller
{
    public function __invoke()
    {
        $categories = Category::all();
        return view('admin.category.index', compact('categories'));
    }
}
