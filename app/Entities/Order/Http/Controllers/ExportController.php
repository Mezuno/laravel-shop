<?php

namespace App\Entities\Order\Http\Controllers;

use App\Entities\Order\Exports\OrderExport;
use Maatwebsite\Excel\Facades\Excel;

class ExportController
{
    public function __invoke()
    {
        return Excel::download(new OrderExport, 'Заказы.xlsx');
    }
}
