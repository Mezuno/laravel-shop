<?php

namespace Database\Seeders;

use App\Entities\Category\Models\Category;
use App\Entities\Product\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];
        $recordCount = 160;

        for ($i = 0; $i < $recordCount; $i++) {
            $data[] = [
                'title' => fake()->word(),
                'description' => fake()->text(70),
                'content' => json_encode(fake()->text(200)),
                'price' => rand(1,100)*10,
                'count' => rand(0, 100),
                'vendor_code' => $i,
                'is_published' => rand(0,1),
                'category_id' => Category::get('id')->random()->id,
                'preview_image' => 'images/products/jZTsJpuBQ9JiKrrUCiIcYNsfl7XZuQHOuR4CS25w.jpg',
                'created_at' => NOW(),
                'updated_at' => NOW(),
            ];
        }

        foreach (array_chunk($data, 1000) as $chunk) {
            Product::insert($chunk);
        }
    }
}
