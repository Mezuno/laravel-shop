<?php

namespace Database\Seeders;

use App\Entities\Product\Models\Product;
use App\Entities\Product\Models\ProductTag;
use App\Entities\Tag\Models\Tag;
use Illuminate\Database\Seeder;

class ProductTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];
        $recordCount = 240;

        for ($i = 0; $i < $recordCount; $i++) {
            $data[] = [
                'tag_id' => Tag::get('id')->random()->id,
                'product_id' => Product::get('id')->random()->id,
                'created_at' => NOW(),
                'updated_at' => NOW(),
            ];
        }

        foreach (array_chunk($data, 1000) as $chunk) {
            ProductTag::insert($chunk);
        }
    }
}
