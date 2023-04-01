<?php

namespace App\Entities\Tag\Http\Controllers;

use App\Http\Controllers\Controller;

class CreateController extends Controller
{
    public function __invoke()
    {
        return view('admin.tag.create');
    }
}
