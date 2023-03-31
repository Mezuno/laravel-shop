<?php

namespace App\Entities\Category\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Entities\Category\Models\Category;

class EditController extends Controller
{
    public function __invoke(Category $category)
    {
        return view('admin.category.edit', compact('category'));
    }
}
