<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductTag extends Model
{
    use HasFactory;
    protected $table = 'product_tag';
    protected $guarded = false;

    public function tag()
    {
        return ProductTag::belongsTo(Tag::class, 'tag_id', 'id');
    }
}
