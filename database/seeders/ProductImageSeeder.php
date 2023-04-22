<?php

namespace Database\Seeders;

use App\Entities\Product\Models\ProductImage;
use Illuminate\Database\Seeder;

class ProductImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];
        $recordCount = 80;

        for ($i = 0; $i < $recordCount; $i++) {
            $data[] = [
                'product_id' => $i+1,
                'file_path' => 'images/products/900x1200-(blue).png',
                'created_at' => NOW(),
                'updated_at' => NOW(),
            ];
            $data[] = [
                'product_id' => $i+1,
                'file_path' => 'images/products/900x1200-(yellow).png',
                'created_at' => NOW(),
                'updated_at' => NOW(),
            ];
            $data[] = [
                'product_id' => $i+1,
                'file_path' => 'images/products/900x1200-(red).png',
                'created_at' => NOW(),
                'updated_at' => NOW(),
            ];
        }

        foreach (array_chunk($data, 1000) as $chunk) {
            ProductImage::insert($chunk);
        }
    }
}
