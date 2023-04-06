<?php

namespace App\Http\API\Controllers\Wishlist;

use App\Entities\Wishlist\Models\Wishlist;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DeleteController extends Controller
{
    public function __invoke(int $wishId)
    {
        $wish = Wishlist::find($wishId);
        return $wish->delete();
    }
}
