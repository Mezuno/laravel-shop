<?php

namespace App\Entities\User\Http\Controllers;

use App\Entities\User\Http\Requests\IndexRequest;
use App\Entities\User\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __invoke(IndexRequest $request)
    {
        $query = User::query();

        $validated = $request->validated();

        if (!$validated) {
            $limit = 8;
            $users = $query->orderByDesc('id')->paginate($limit);
            return view('admin.user.index')->with(['users' => $users]);
        }

        if ($validated['id']) {
            $query->where('id', '=', $validated['id']);
        }

        if ($validated['name']) {
            $query->where('name', 'like', '%'.$validated['name'].'%');
        }

        if ($validated['surname']) {
            $query->where('surname', 'like', '%'.$validated['surname'].'%');
        }

        if ($validated['patronymic']) {
            $query->where('patronymic', 'like', '%'.$validated['patronymic'].'%');
        }

        if ($validated['email']) {
            $query->where('email', 'like', '%'.$validated['email'].'%');
        }

        if ($validated['age']) {
            $query->where('age', '=', $validated['age']);
        }

        if ($validated['gender']) {
            $query->where('gender', '=', $validated['gender']);
        }

        if ($validated['size']) {
            if ((int)$validated['size'] <= 0) {
                $limit = 8;
            } else {
                $limit = (int)$validated['size'];
            }
        } else {
            $limit = 8;
        }

        if (!$request->has('deleted')) {
            $validated['deleted'] = null;
        }
        if ($validated['deleted']) {
            $query->withTrashed();
        }

        $users = $query->orderByDesc('id')->paginate($limit);

        return view('admin.user.index')->with(['users' => $users]);
    }
}
