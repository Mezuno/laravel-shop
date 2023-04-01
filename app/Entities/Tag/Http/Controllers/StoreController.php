<?php

namespace App\Entities\Tag\Http\Controllers;

use App\Entities\Tag\Http\Requests\StoreRequest;
use App\Entities\Tag\Models\Tag;
use App\Http\Controllers\Controller;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request)
    {
        $data = $request->validated();
        Tag::firstOrCreate($data);
        return redirect()->route('tag.index');
    }
}
