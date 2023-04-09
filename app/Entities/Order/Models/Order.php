<?php

namespace App\Entities\Order\Models;

use App\Entities\User\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory;
    use SoftDeletes;

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

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
