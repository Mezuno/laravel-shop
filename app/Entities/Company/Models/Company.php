<?php

namespace App\Entities\Company\Models;

use App\Entities\Product\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $table = 'companies';
    protected $guarded = false;

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
