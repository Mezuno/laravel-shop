<?php

namespace Database\Seeders;

use App\Entities\Company\Models\Company;
use App\Entities\Product\Models\Product;
use App\Entities\Product\Models\ProductCompany;
use Illuminate\Database\Seeder;

class ProductCompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];
        $recordCount = 120;

        for ($i = 0; $i < $recordCount; $i++) {
            $data[] = [
                'company_id' => Company::get('id')->random()->id,
                'product_id' => Product::get('id')->random()->id,
                'created_at' => NOW(),
                'updated_at' => NOW(),
            ];
        }

        foreach (array_chunk($data, 1000) as $chunk) {
            ProductCompany::insert($chunk);
        }
    }
}
