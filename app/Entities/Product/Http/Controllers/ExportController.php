<?php

namespace App\Entities\Product\Http\Controllers;

use App\Entities\Product\Exports\ProductExport;
use Maatwebsite\Excel\Facades\Excel;

class ExportController
{
    public function __invoke()
    {
        return Excel::download(new ProductExport, 'Товары.xlsx');
    }
}
