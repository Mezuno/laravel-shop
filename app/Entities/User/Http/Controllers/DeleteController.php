<?php

namespace App\Entities\User\Http\Controllers;

use App\Entities\User\Models\User;
use App\Http\Controllers\Controller;

class DeleteController extends Controller
{
    public function __invoke(User $user)
    {
        $this->authorize('delete', [$user, auth()->user()]);
        $user->delete();
        return redirect()->route('user.index')->with(['success' => 'Пользователь id' . $user->id . ' успешно удален']);
    }
}
