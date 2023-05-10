<?php

namespace App\Entities\Product\Exports;

use App\Entities\Product\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Product::all();
    }

    /**
     * @var Product $product
     */
    public function map($product): array
    {
        return [
            $product->id,
            $product->vendor_code,
            $product->title,
            $product->price,
            $product->category->title,
            $product->count,
            $product->description,
            $product->content,
            $product->deleted_at,
            $product->created_at,
            $product->updated_at,
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
            'Артикул',
            'Название',
            'Цена (₽)',
            'Категория',
            'Кол-во на складе',
            'Описание',
            'Контент',
            'Дата удаления',
            'Дата создания',
            'Дата обновления',
        ];
    }
}
