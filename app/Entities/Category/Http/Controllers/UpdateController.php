<?php

namespace App\Entities\Category\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Entities\Category\Models\Category;
use App\Entities\Category\Http\Requests\UpdateRequest;

class UpdateController extends Controller
{
    public function __invoke(UpdateRequest $request, Category $category)
    {
        $data = $request->validated();
        $category->update($data);

        return redirect()->route('category.show', compact('category'))->with(['success' => 'Категория id' . $category->id . ' успешно обновлена']);
    }
}
