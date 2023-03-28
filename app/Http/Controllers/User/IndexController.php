<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;

class IndexController extends Controller
{
    public function __invoke()
    {
        $query = User::query();
        $users = $query->paginate(8);
        return view('user.index', compact('users'));
    }
}
