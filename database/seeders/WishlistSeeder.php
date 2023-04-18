<?php

namespace Database\Seeders;

use App\Entities\Product\Models\Product;
use App\Entities\User\Models\User;
use App\Entities\Wishlist\Models\Wishlist;
use Illuminate\Database\Seeder;

class WishlistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];
        $recordCount = 320;

        for ($i = 0; $i < $recordCount; $i++) {
            $data[] = [
                'user_id' => User::get('id')->random()->id,
                'product_id' => Product::get('id')->random()->id,
                'updated_at' => now()->add('day', 30),
                'created_at' => (now()->year . '-' . now()->month . '-' . rand(1, 29) . ' ' . now()->hour . ':' . now()->minute . ':' . now()->second),
            ];
        }

        foreach (array_chunk($data, 1000) as $chunk) {
            Wishlist::insert($chunk);
        }
    }
}
