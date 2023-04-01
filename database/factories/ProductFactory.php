<?php

namespace Database\Factories;

use App\Entities\Category\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->word(),
            'description' => fake()->text(70),
            'content' => json_encode(fake()->text(200)),
            'price' => rand(1,100)*10,
            'count' => rand(0, 100),
            'is_published' => rand(0,1),
            'category_id' => Category::get('id')->random()->id,
            'preview_image' => 'images/products/jZTsJpuBQ9JiKrrUCiIcYNsfl7XZuQHOuR4CS25w.jpg',
        ];
    }
}
