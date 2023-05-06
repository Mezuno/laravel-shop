<?php

namespace App\Entities\Order\Exports;

use App\Entities\Order\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class OrderExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Order::all();
    }

    /**
     * @var Order $order
     */
    public function map($order): array
    {
        return [
            $order->id,
            $order->user_id,
            $order->orderer->name,
            $order->products,
            $order->total_price,
            $order->payment_status,
            $order->address,
            $order->deleted_at,
            $order->created_at,
            $order->updated_at,
        ];
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
            'Имя заказчика',
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
