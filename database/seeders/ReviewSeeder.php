<?php

namespace Database\Seeders;

use App\Entities\Category\Models\Category;
use App\Entities\Product\Models\Product;
use App\Entities\Review\Models\Review;
use App\Entities\User\Models\User;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];
        $recordCount = 1280;

        $rates = [rand(1,2), rand(3,5), rand(3,5), rand(4,5)];

        for ($i = 0; $i < $recordCount; $i++) {
            $data[] = [
                'user_id' => User::get('id')->random()->id,
                'product_id' => Product::get('id')->random()->id,
                'title' => fake()->text(70),
                'rate' => $rates[array_rand($rates, 1)],
                'advantages' => fake()->text(70),
                'flaws' => fake()->text(70),
                'body' => fake()->text(255),
                'confirmed_at' => [fake()->dateTime, fake()->dateTime, null][array_rand([fake()->dateTime, fake()->dateTime, null])],
                'created_at' => NOW(),
                'updated_at' => NOW(),
                'deleted_at' => [fake()->dateTime, null, null, null, null][array_rand([fake()->dateTime, null, null, null, null])],
            ];
        }

        foreach (array_chunk($data, 1000) as $chunk) {
            Review::insert($chunk);
        }
    }
}
