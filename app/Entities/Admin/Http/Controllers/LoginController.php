<?php

namespace App\Entities\Admin\Http\Controllers;

use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    public function __invoke()
    {
        return view('admin.admin-login');
    }
}
