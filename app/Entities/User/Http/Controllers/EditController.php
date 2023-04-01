<?php

namespace App\Entities\User\Http\Controllers;

use App\Entities\User\Models\User;
use App\Http\Controllers\Controller;

class EditController extends Controller
{
    public function __invoke(User $user)
    {
        return view('admin.user.edit', compact('user'));
    }
}
