<?php

namespace Database\Seeders;

use App\Entities\Category\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::insert([
            [
                'title' => 'Высшая категория',
                'created_at' => NOW(),
                'updated_at' => NOW(),
            ], [
                'title' => 'Средняя категория',
                'created_at' => NOW(),
                'updated_at' => NOW(),
            ], [
                'title' => 'Низшая категория',
                'created_at' => NOW(),
                'updated_at' => NOW(),
            ]
        ]);
    }
}
