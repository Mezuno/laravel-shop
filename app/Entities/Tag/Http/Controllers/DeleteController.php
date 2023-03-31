<?php

namespace App\Entities\Tag\Http\Controllers;

use App\Entities\Product\Models\ProductTag;
use App\Entities\Tag\Models\Tag;
use App\Http\Controllers\Controller;

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
