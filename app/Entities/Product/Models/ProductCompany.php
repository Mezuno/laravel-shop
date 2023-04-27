<?php

namespace App\Entities\Product\Models;

use App\Entities\Company\Models\Company;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCompany extends Model
{
    use HasFactory;
    protected $table = 'product_companies';
    protected $guarded = false;

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }
}
