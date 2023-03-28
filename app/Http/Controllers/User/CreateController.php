<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

class CreateController extends Controller
{
    public function __invoke()
    {
        return view('user.create');
    }
}
