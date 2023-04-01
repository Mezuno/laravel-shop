<?php

namespace App\Entities\Tag\Models;

use App\Entities\Product\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    protected $table = 'tags';
    protected $guarded = false;

    public function products()
    {
        return Tag::belongsToMany(Product::class);
    }
}
