<?php

namespace App\Entities\User\Http\Controllers;

use App\Entities\User\Http\Requests\IndexRequest;
use App\Entities\User\Models\User;
use App\Http\Controllers\Controller;
use App\Traits\AdminFilterHelperTrait;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    use AdminFilterHelperTrait;

    public function __invoke(IndexRequest $request)
    {
        $query = User::query();

        $validated = $request->validated();

        $limit = $this->getFilterSize($request, $validated);

        if (!$validated) {
            $users = $query->orderByDesc('id')->paginate($limit);
            return view('admin.user.index')->with(['users' => $users]);
        }

        $this->addWhereFilterToQuery($query, $request, $validated, 'id', '=');
        $this->addWhereFilterToQuery($query, $request, $validated, 'name', 'like', true);
        $this->addWhereFilterToQuery($query, $request, $validated, 'surname', 'like', true);
        $this->addWhereFilterToQuery($query, $request, $validated, 'patronymic', 'like', true);
        $this->addWhereFilterToQuery($query, $request, $validated, 'email', 'like', true);
        $this->addWhereFilterToQuery($query, $request, $validated, 'age', '=');
        $this->addWhereFilterToQuery($query, $request, $validated, 'gender', '=');

        $this->addWithTrashedFilterToQuery($query, $request, $validated);

        $users = $query->orderByDesc('id')->paginate($limit);

        return view('admin.user.index')->with(['users' => $users]);
    }
}
