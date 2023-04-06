<?php

namespace App\Entities\Order\Exports;

use App\Entities\Order\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OrderExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Order::all();
    }

    /**
     * Add heading row
     *
     * @return string[]
     */
    public function headings(): array
    {
        return [
            'ID',
            'ID заказчика',
            'Товары',
            'Сумма (₽)',
            'Статус оплаты',
            'Адрес',
            'Дата удаления',
            'Дата создания',
            'Дата обновления',
        ];
    }
}
