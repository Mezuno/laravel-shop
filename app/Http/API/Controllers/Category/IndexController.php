<?php

namespace App\Http\API\Controllers\Category;

use App\Entities\Category\Http\Resources\CategoryResource;
use App\Entities\Category\Models\Category;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function __invoke()
    {
        $category = Category::all();
        return CategoryResource::collection($category);
    }
}
