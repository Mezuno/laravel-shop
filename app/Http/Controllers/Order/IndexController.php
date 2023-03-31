<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __invoke(Request $request)
    {
        $query = Order::query();

        // Поиск по user name и user email
        if ($request->has('user') && $request->get('user') != null) {
            $query->where('user_id', '=', $request->get('user'));
        }

        // Поиск по товарам - как!?

//        if ($request->has('vendor_code') && $request->get('vendor_code') != null) {
//            dump($request->get('vendor_code'));
//            $query->whereJsonContains('products->*->vendor_code', $request->get('vendor_code'));
//            $query->whereRaw('JSON_VALUE(products, ?) = ?', ['$.vendor_code', $request->get('vendor_code')]);
//            $query->whereRaw("jsonb_exists(json->'products', ". $request->get('vendor_code') .")");
//        }

        if ($request->has('price_from') && $request->get('price_from') != null) {
            $query->where('total_price', '>=', $request->get('price_from'));
        }
        if ($request->has('price_to') && $request->get('price_to') != null) {
            $query->where('total_price', '<=', $request->get('price_to'));
        }
        if ($request->has('payment_status_true') && $request->get('payment_status_true') != null) {
            if ($request->get('payment_status_true') == 'on' && $request->get('payment_status_false') != 'on') {
                $payment_status = 1;
                $query->where('payment_status', '=', $payment_status);
            }
        }
        if ($request->has('payment_status_false') && $request->get('payment_status_false') != null) {
            if ($request->get('payment_status_false') == 'on' && $request->get('payment_status_true') != 'on') {
                $payment_status = 0;
                $query->where('payment_status', '=', $payment_status);
            }
        }
        if ($request->has('size')) {
            if ((int)$request->get('size') <= 0) {
                $limit = 8;
            } else {
                $limit = (int)$request->get('size');
            }
        } else {
            $limit = 8;
        }

        $orders = $query->withTrashed()->with('orderer')->orderByDesc('id')->paginate($limit);

        return view('order.index')->with(['orders' => $orders]);
    }
}
