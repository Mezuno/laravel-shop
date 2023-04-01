<?php

namespace App\Entities\Product\Http\Controllers;

use App\Entities\Category\Models\Category;
use App\Entities\Tag\Models\Tag;
use App\Http\Controllers\Controller;

class CreateController extends Controller
{
    public function __invoke()
    {
        $tags = Tag::all();
        $categories = Category::all();
        return view('admin.product.create', compact('tags', 'categories'));
    }
}
