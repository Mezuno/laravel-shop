<?php

namespace App\Entities\Tag\Http\Controllers;

use App\Entities\Tag\Models\Tag;
use App\Http\Controllers\Controller;

class ShowController extends Controller
{
    public function __invoke(Tag $tag)
    {
        return view('admin.tag.show', compact('tag'));
    }
}
