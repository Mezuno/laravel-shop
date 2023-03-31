<?php

namespace App\Http\Controllers\Admin;

class LoginController
{
    public function __invoke()
    {
        return view('admin.admin-login');
    }
}
