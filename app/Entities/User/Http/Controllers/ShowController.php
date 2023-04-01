<?php

namespace App\Entities\User\Http\Controllers;

use App\Entities\User\Models\User;
use App\Http\Controllers\Controller;

class ShowController extends Controller
{
    public function __invoke(User $user)
    {
        return view('admin.user.show', compact('user'));
    }
}
