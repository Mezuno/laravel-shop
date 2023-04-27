<?php

namespace Database\Seeders;

use App\Entities\Company\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Company::insert([
            [
                'title' => 'Apple',
                'created_at' => NOW(),
                'updated_at' => NOW(),
            ], [
                'title' => 'Microsoft',
                'created_at' => NOW(),
                'updated_at' => NOW(),
            ], [
                'title' => 'Amazon',
                'created_at' => NOW(),
                'updated_at' => NOW(),
            ], [
                'title' => 'Samsung',
                'created_at' => NOW(),
                'updated_at' => NOW(),
            ], [
                'title' => 'Xiaomi',
                'created_at' => NOW(),
                'updated_at' => NOW(),
            ],
        ]);
    }
}
