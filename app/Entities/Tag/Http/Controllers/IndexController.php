<?php

namespace App\Entities\Tag\Http\Controllers;

use App\Entities\Tag\Models\Tag;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function __invoke()
    {
        $tags = Tag::all();
        return view('admin.tag.index', compact('tags'));
    }
}
