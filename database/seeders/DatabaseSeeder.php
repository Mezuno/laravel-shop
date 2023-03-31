<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Entities\Category\Models\Category;
use App\Entities\Product\Models\Product;
use App\Entities\Product\Models\ProductTag;
use App\Entities\Tag\Models\Tag;
use App\Entities\User\Models\User;
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
        User::factory(10)->create();

        User::factory()->create([
            'name' => 'Кирилл',
            'surname' => 'Цыбульский',
            'patronymic' => 'Андреевич',
            'email' => 'mekishido@gmail.com',
            'password' => Hash::make('12345678'),
            'is_admin' => 1,
        ]);

        Category::factory()->create([
            'title' => 'Высшая категория',
        ]);
        Category::factory()->create([
            'title' => 'Средняя категория',
        ]);
        Category::factory()->create([
            'title' => 'Низшая категория',
        ]);
        Tag::factory()->create([
            'title' => 'Лучшая цена',
        ]);
        Tag::factory()->create([
            'title' => 'Хит',
        ]);
        Tag::factory()->create([
            'title' => 'Последняя партия',
        ]);

        Product::factory(160)->sequence(fn (Sequence $sequence) => ['vendor_code' => $sequence->index+1])->create();

        ProductTag::factory(320)->create();
    }
}
