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


    const PAYMENT_TRUE = 1;
    const PAYMENT_FALSE = 0;

    const STATUS_PROCESSED = 0;
    const STATUS_DELIVERED = 1;

    static function getPaymentStatusString()
    {
        return [
            self::PAYMENT_TRUE => 'Оплачен',
            self::PAYMENT_FALSE => 'Ожидает оплаты',
        ];
    }

    public function getPaymentStatusStringAttribute()
    {
        return self::getPaymentStatusString()[$this->payment_status];
    }

    static function getOrderStatusString()
    {
        return [
            self::STATUS_DELIVERED => 'Доставлен',
            self::STATUS_PROCESSED => 'Оформлен',
        ];
    }

    public function getOrderStatusStringAttribute()
    {
        return self::getPaymentStatusString()[$this->status];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
