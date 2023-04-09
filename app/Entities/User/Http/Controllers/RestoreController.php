<?php

namespace App\Entities\User\Http\Controllers;

use App\Entities\User\Http\Requests\UpdateRequest;
use App\Entities\User\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class RestoreController extends Controller
{
    public function __invoke(int $userId)
    {
        User::withTrashed()->where('id', $userId)->update(['deleted_at' => null]);
        $user = User::find($userId);
        return redirect()->route('user.show', compact('user'))->with(['success' => 'Пользователь id' . $user->id . ' успешно восстановлен']);
    }
}
