<?php

namespace Database\Factories;

use App\Entities\Product\Models\Product;
use App\Entities\Product\Models\ProductTag;
use App\Entities\Tag\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<ProductTag>
 */
class ProductTagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tag_id' => Tag::get('id')->random()->id,
            'product_id' => Product::get('id')->random()->id,
        ];
    }
}
