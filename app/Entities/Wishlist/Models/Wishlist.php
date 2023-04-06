<?php

namespace App\Entities\Wishlist\Models;

use App\Entities\User\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;
    protected $table = 'wishlists';
    protected $guarded = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
