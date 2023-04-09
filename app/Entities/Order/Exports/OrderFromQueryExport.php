<?php

namespace App\Entities\Order\Exports;

use App\Entities\Order\Models\Order;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\WithMapping;

class OrderFromQueryExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
    use Exportable;

    protected $user_id = null;
    protected $vendor_code = null;
    protected $payment_status = null;
    protected $price_from = null;
    protected $price_to = null;
    protected $size = null;
    protected $deleted = null;

    public function __construct(Request $request)
    {
        if ($request->has('user_id') && $request->get('user_id') != null) {
            $this->user_id = $request->get('user_id');
        }
//        if ($request->has('vendor_code') && $request->get('vendor_code') != null) {
//            $this->vendor_code = $request->get('vendor_code');
//        }
        if ($request->has('payment_status_true') && $request->get('payment_status_true') != null) {
            if ($request->get('payment_status_true') == 'on' && $request->get('payment_status_false') != 'on') {
                $this->payment_status = true;
            }
        }
        if ($request->has('payment_status_false') && $request->get('payment_status_false') != null) {
            if ($request->get('payment_status_false') == 'on' && $request->get('payment_status_true') != 'on') {
                $this->payment_status = false;
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
        $query = Order::query();

        if ($this->user_id != null) {
            $query->where('user_id', 'like', '%'.$this->user_id.'%');
        }
//        if ($this->vendor_code != null) {
//            $query->where('products', '=', $this->vendor_code);
//        }
        if ($this->payment_status != null) {
            $query->where('payment_status', '=', $this->payment_status);
        }
        if ($this->deleted) {
            $query->withTrashed();
        }
//        dd($query->whereBetween('total_price', [$this->total_price_from, $this->total_price_to])->with('category')->orderByDesc('id')->get());

        // ->take($this->size) если надо будет выгружать не все а по фильтру (кол-во)
        return $query->whereBetween('total_price', [$this->price_from, $this->price_to])->with('user')->orderByDesc('id');
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
