<?php

namespace App\Entities\User\Http\Controllers;

use App\Http\Controllers\Controller;

class CreateController extends Controller
{
    public function __invoke()
    {
        return view('admin.user.create');
    }
}
