<?php

namespace App\Entities\User\Http\Controllers;

use App\Entities\User\Http\Requests\UpdateRequest;
use App\Entities\User\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UpdateController extends Controller
{
    public function __invoke(UpdateRequest $request, User $user)
    {
        $data = $request->validated();
        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = Hash::make($data['password']);
        }
        $user->update($data);
        return redirect()->route('user.show', compact('user'))->with(['success' => 'Пользователь id' . $user->id . ' успешно обновлен']);
    }
}
