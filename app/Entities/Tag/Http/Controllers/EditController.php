<?php

namespace App\Entities\Tag\Http\Controllers;

use App\Entities\Tag\Models\Tag;
use App\Http\Controllers\Controller;

class EditController extends Controller
{
    public function __invoke(Tag $tag)
    {
        return view('admin.tag.edit', compact('tag'));
    }
}
