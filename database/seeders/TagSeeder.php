<?php

namespace Database\Seeders;

use App\Entities\Tag\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tag::insert([
            [
                'title' => 'Лучшая цена',
                'created_at' => NOW(),
                'updated_at' => NOW(),
            ], [
                'title' => 'Хит',
                'created_at' => NOW(),
                'updated_at' => NOW(),
            ], [
                'title' => 'Последняя партия',
                'created_at' => NOW(),
                'updated_at' => NOW(),
            ]
        ]);
    }
}
