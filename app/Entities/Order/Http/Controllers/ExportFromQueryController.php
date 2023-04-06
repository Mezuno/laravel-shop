<?php

namespace App\Entities\Order\Http\Controllers;

use App\Entities\Order\Exports\OrderFromQueryExport;
use Illuminate\Http\Request;

class ExportFromQueryController
{
    public function __invoke(Request $request)
    {
        return (new OrderFromQueryExport($request))->download('Заказы (с фильтром).xlsx');
    }
}
