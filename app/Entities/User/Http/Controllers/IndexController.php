<?php

namespace App\Entities\User\Http\Controllers;

use App\Entities\User\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __invoke(Request $request)
    {
        $query = User::query();

        if ($request->has('id') && $request->get('id') != null) {
            $query->where('id', '=', $request->get('id'));
        }
        if ($request->has('name') && $request->get('name') != null) {
            $query->where('name', 'like', '%'.$request->get('name').'%');
        }
        if ($request->has('surname') && $request->get('surname') != null) {
            $query->where('surname', 'like', '%'.$request->get('surname').'%');
        }
        if ($request->has('patronymic') && $request->get('patronymic') != null) {
            $query->where('patronymic', 'like', '%'.$request->get('patronymic').'%');
        }
        if ($request->has('email') && $request->get('email') != null) {
            $query->where('email', 'like', '%'.$request->get('email').'%');
        }
        if ($request->has('age') && $request->get('age') != null) {
            $query->where('age', '=', $request->get('age'));
        }
        if ($request->has('gender') && $request->get('gender') != null) {
            $query->where('gender', '=', $request->get('gender'));
        }

        if ($request->has('size')) {
            if ((int)$request->get('size') <= 0) {
                $limit = 8;
            } else {
                $limit = (int)$request->get('size');
            }
        } else {
            $limit = 8;
        }
        if ($request->has('deleted') && $request->get('deleted') != null) {
            $query->withTrashed();
        }

        $users = $query->orderByDesc('id')->paginate($limit);

        return view('admin.user.index')->with(['users' => $users]);
    }
}
