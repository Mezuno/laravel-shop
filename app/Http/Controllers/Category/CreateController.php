<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;

class CreateController extends Controller
{
    public function __invoke()
    {
        return view('category.create');
    }
}
