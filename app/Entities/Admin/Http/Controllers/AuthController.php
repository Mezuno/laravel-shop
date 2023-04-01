<?php

namespace App\Entities\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController
{
    public function __invoke(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password'], 'is_admin' => 1])) {
            $request->session()->regenerate();
            return redirect()->route('main.index');
        }

        return back()->with(['message' => 'Введены неверные автризационные данные'])->onlyInput('email');
    }
}
