<?php

namespace App\Entities\Product\Http\Controllers;

use App\Entities\Product\Exports\ProductFromQueryExport;
use Illuminate\Http\Request;

class ExportFromQueryController
{
    public function __invoke(Request $request)
    {
        return (new ProductFromQueryExport($request))->download('Товары (с фильтром).xlsx');
    }
}
