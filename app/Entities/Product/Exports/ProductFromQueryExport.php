<?php

namespace App\Entities\Product\Exports;

use App\Entities\Product\Models\Product;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductFromQueryExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
    use Exportable;

    protected $title = null;
    protected $vendor_code = null;
    protected $description = null;
    protected $content = null;
    protected $price_from = null;
    protected $price_to = null;
    protected $is_published = null;
    protected $size = null;
    protected $deleted = null;

    public function __construct(Request $request)
    {
        if ($request->has('title') && $request->get('title') != null) {
            $this->title = $request->get('title');
        }
        if ($request->has('vendor_code') && $request->get('vendor_code') != null) {
            $this->vendor_code = $request->get('vendor_code');
        }
        if ($request->has('description') && $request->get('description') != null) {
            $this->description = $request->get('description');
        }
        if ($request->has('content') && $request->get('content') != null) {
            $this->content = $request->get('content');
        }
        if ($request->has('is_published') && $request->get('is_published') != null) {
            if ($request->get('is_published') == 'on' && $request->get('is_not_published') != 'on') {
                $this->is_published = true;
            }
        }
        if ($request->has('is_not_published') && $request->get('is_not_published') != null) {
            if ($request->get('is_not_published') == 'on' && $request->get('is_published') != 'on') {
                $this->is_published = false;
            }
        }
        if ($request->has('price_from') || $request->get('price_from') == '') {
            if ($request->get('price_from') < 0) {
                $this->price_from = 0;
            } else {
                $this->price_from = (int)$request->get('price_from');
            }
        } else {
            $this->price_from = 0;
        }
        if ($request->has('price_to')) {
            if ($request->get('price_to') > 100000 || $request->get('price_to') == '') {
                $this->price_to = 100000;
            } else {
                $this->price_to = (int)$request->get('price_to');
            }
        } else {
            $this->price_to = 100000;
        }
        if ($request->has('size')) {
            if ((int)$request->get('size') <= 0) {
                $this->size = 8;
            } else {
                $this->size = (int)$request->get('size');
            }
        } else {
            $this->size = 8;
        }
        if ($request->has('deleted') && $request->get('deleted') != null) {
            $this->deleted = true;
        }
    }

    public function query()
    {
        $query = Product::query();

        if ($this->title != null) {
            $query->where('title', 'like', '%'.$this->title.'%');
        }
        if ($this->vendor_code != null) {
            $query->where('vendor_code', '=', $this->vendor_code);
        }
        if ($this->description != null) {
            $query->where('description', 'like', '%'.$this->description.'%');
        }
        if ($this->content != null) {
            $query->where('content', 'like', '%'.$this->content.'%');
        }
        if ($this->is_published != null) {
            $query->where('is_published', '=', $this->is_published);
        }
        if ($this->deleted) {
            $query->withTrashed();
        }
//        dd($query->whereBetween('price', [$this->price_from, $this->price_to])->with('category')->orderByDesc('id')->get());

        // ->take($this->size) если надо будет выгружать не все а по фильтру (кол-во)
        return $query->whereBetween('price', [$this->price_from, $this->price_to])->with('category')->orderByDesc('id');
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
