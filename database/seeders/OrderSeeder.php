<?php

namespace Database\Seeders;

use App\Entities\Order\Models\Order;
use App\Entities\Product\Models\Product;
use App\Entities\User\Models\User;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];
        $recordCount = 20;

        for ($i = 0; $i < $recordCount; $i++) {
            $products = [];
            for ($j = 0; $j < 3; $j++) {
                $product = Product::get()->random();
                $products[] = [
                    'id' => $product->id,
                    'title' => $product->title,
                    'price' => $product->price,
                    'image_url' => $product->imageUrl,
                    'vendor_code' => $product->vendor_code,
                    'qty' => rand(1, 10),
                ];
            }
            $data[] = [
                'user_id' => User::get('id')->random()->id,

                'products' => json_encode($products),

                'total_price' => rand(1,100)*100,
                'payment_status' => rand(0,1),
                'address' => fake()->address(),
                'deleted_at' => [fake()->dateTime, null][array_rand([fake()->dateTime, null])],
                'updated_at' => now(),
                'created_at' => now(),
            ];
        }

        foreach (array_chunk($data, 1000) as $chunk) {
            Order::insert($chunk);
        }
    }
}
