<?php

namespace Database\Seeders;

use App\Entities\Category\Models\Category;
use App\Entities\Company\Models\Company;
use App\Entities\Product\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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

        $files_preview_image = Storage::files('/public/images/products/');

        for ($i = 0; $i < $recordCount; $i++) {
            $data[] = [
                'title' => Str::title(fake()->word()),
                'description' => fake()->text(70),
                'content' => json_encode([
                    Str::title(fake()->word) => fake()->sentence(rand(1,3)),
                    Str::title(fake()->word) => fake()->sentence(rand(1,3)),
                    Str::title(fake()->word) => fake()->sentence(rand(1,3)),
                    Str::title(fake()->word) => fake()->sentence(rand(1,3)),
                    Str::title(fake()->word) => fake()->sentence(rand(1,3)),
                ]),
                'price' => rand(1,100)*10,
                'count' => rand(0, 100),
                'vendor_code' => $i+1,
                'company_id' => Company::get('id')->random()->id,
                'is_published' => rand(0,1),
                'category_id' => Category::get('id')->random()->id,
                'preview_image' => mb_substr($files_preview_image[array_rand($files_preview_image, 1)], 7),
                'created_at' => NOW(),
                'updated_at' => NOW(),
            ];
        }

        foreach (array_chunk($data, 1000) as $chunk) {
            Product::insert($chunk);
        }
    }
}
