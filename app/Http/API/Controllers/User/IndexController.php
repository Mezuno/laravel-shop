<?php

namespace App\Http\API\Controllers\User;

use App\Entities\User\Models\User;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function __invoke()
    {
        $users = User::all();
        return response()->json($users);
    }
}
