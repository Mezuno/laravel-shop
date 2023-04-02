<?php

namespace App\Entities\Category\Models;

use Database\Factories\CategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = 'categories';
    protected $guarded = false;

    protected static function newFactory()
    {
        return CategoryFactory::new();
    }
}
