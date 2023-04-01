<?php

namespace App\Entities\User\Http\Controllers;

use App\Entities\User\Http\Requests\StoreRequest;
use App\Entities\User\Models\User;
use App\Http\Controllers\Controller;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request)
    {
        $data = $request->validated();
        User::firstOrCreate([
            'email' => $data['email'],
        ], $data);
        return redirect()->route('user.index');
    }
}
