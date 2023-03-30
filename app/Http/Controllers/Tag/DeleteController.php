<?php

namespace App\Http\Controllers\Tag;

use App\Http\Controllers\Controller;
use App\Models\ProductTag;
use App\Models\Tag;

class DeleteController extends Controller
{
    public function __invoke(Tag $tag)
    {
        $productTag = ProductTag::where('tag_id', $tag->id)->get()->first();
        if ($productTag) {
            return back()->with(['error' => 'Тег id' . $tag->id . ' привязан к товару, поэтому не может быть удален']);
        }
        $tag->delete();
        return redirect()->route('tag.index')->with(['success' => 'Тег id' . $tag->id . ' успешно удален']);
    }
}
