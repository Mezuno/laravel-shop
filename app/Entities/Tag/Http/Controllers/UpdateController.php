<?php

namespace App\Entities\Tag\Http\Controllers;

use App\Entities\Tag\Http\Requests\UpdateRequest;
use App\Entities\Tag\Models\Tag;
use App\Http\Controllers\Controller;

class UpdateController extends Controller
{
    public function __invoke(UpdateRequest $request, Tag $tag)
    {
        $data = $request->validated();
        $tag->update($data);

        return redirect()->route('tag.show', compact('tag'))->with(['success' => 'Тег id' . $tag->id . ' успешно обновлен']);
    }
}
