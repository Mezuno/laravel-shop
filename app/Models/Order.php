<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $guarded = false;

//    const PAYMENT_TRUE = 1;
//    const PAYMENT_FALSE = 0;
//
//    static function getPaymentStatus()
//    {
//        return [
//            self::PAYMENT_TRUE => 'Оплачен',
//            self::PAYMENT_FALSE => 'Не оплачен',
//        ];
//    }
//
//    public function getPaymentStatusAttribute()
//    {
//        return self::getPaymentStatus()[$this->payment_status];
//    }
}
