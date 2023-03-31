<?php

namespace App\Entities\Category\Http\Controllers;

use App\Http\Controllers\Controller;

class CreateController extends Controller
{
    public function __invoke()
    {
        return view('admin.category.create');
    }
}
