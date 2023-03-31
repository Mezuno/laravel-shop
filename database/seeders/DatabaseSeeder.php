<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Кирилл',
            'surname' => 'Цыбульский',
            'patronymic' => 'Андреевич',
            'email' => 'mekishido@gmail.com',
            'password' => Hash::make('12345678'),
            'is_admin' => 1,
        ]);

        \App\Models\Category::factory()->create([
            'title' => 'Высшая категория',
        ]);
        \App\Models\Category::factory()->create([
            'title' => 'Средняя категория',
        ]);
        \App\Models\Category::factory()->create([
            'title' => 'Низшая категория',
        ]);
        \App\Models\Tag::factory()->create([
            'title' => 'Лучшая цена',
        ]);
        \App\Models\Tag::factory()->create([
            'title' => 'Хит',
        ]);
        \App\Models\Tag::factory()->create([
            'title' => 'Последняя партия',
        ]);

        \App\Models\Product::factory(160)->sequence(fn (Sequence $sequence) => ['vendor_code' => $sequence->index+1])->create();

        \App\Models\ProductTag::factory(320)->create();
    }
}
