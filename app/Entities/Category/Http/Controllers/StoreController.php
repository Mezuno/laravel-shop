<?php

namespace App\Entities\Category\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Entities\Category\Models\Category;
use App\Entities\Category\Http\Requests\StoreRequest;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request)
    {
        $data = $request->validated();
        Category::firstOrCreate($data);
        return redirect()->route('category.index');
    }
}
