<?php

namespace App\Entities\Product\Models;

use App\Entities\Category\Models\Category;
use App\Entities\Review\Models\Review;
use App\Entities\Tag\Models\Tag;
use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use Filterable;
    use HasFactory;
    use SoftDeletes;

    protected $table = 'products';

    protected $guarded = false;

    const PUBLISHED_TRUE = 1;
    const PUBLISHED_FALSE = 0;

    static function getPublishedStatus()
    {
        return [
            self::PUBLISHED_TRUE => 'Опубликовано',
            self::PUBLISHED_FALSE => 'Не опубликовано',
        ];
    }

    public function getPublishedStatusAttribute()
    {
        return self::getPublishedStatus()[$this->is_published];
    }

    public function getImageUrlAttribute()
    {
        return url('storage/' . $this->preview_image);
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function productImages()
    {
        return $this->hasMany(ProductImage::class, 'product_id', 'id');
    }

    public function review()
    {
        return $this->hasMany(Review::class);
    }
}
