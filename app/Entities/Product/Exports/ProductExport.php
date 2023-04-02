<?php

namespace App\Entities\Product\Exports;

use App\Entities\Product\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Product::all();
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
            'Название',
            'Описание',
            'Контент',
            'Превью URL',
            'Артикул',
            'Цена (₽)',
            'Кол-во на складе',
            'Опубликовано',
            'Категория',
            'Дата удаления',
            'Дата создания',
            'Дата обновления',
        ];
    }
}
