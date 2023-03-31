<?php

namespace App\Entities\User\Http\Controllers;

use App\Entities\User\Models\User;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function __invoke()
    {
        $query = User::query();
        $users = $query->paginate(8);
        return view('admin.user.index', compact('users'));
    }
}
