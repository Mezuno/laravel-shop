<?php

namespace Database\Factories\Entities\Product\Models;

use App\Entities\Product\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;
    private $files_preview_image;

    public function __construct($count = null, ?Collection $states = null, ?Collection $has = null, ?Collection $for = null, ?Collection $afterMaking = null, ?Collection $afterCreating = null, $connection = null, ?Collection $recycle = null)
    {
        parent::__construct($count, $states, $has, $for, $afterMaking, $afterCreating, $connection, $recycle);

        $this->files_preview_image = Storage::files('/public/images/products/');
    }

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => Str::title(fake()->word()),
            'description' => fake()->text(70),
            'content' => json_encode([
                Str::title(fake()->word) => fake()->sentence(rand(1, 3)),
                Str::title(fake()->word) => fake()->sentence(rand(1, 3)),
                Str::title(fake()->word) => fake()->sentence(rand(1, 3)),
                Str::title(fake()->word) => fake()->sentence(rand(1, 3)),
                Str::title(fake()->word) => fake()->sentence(rand(1, 3)),
            ]),
            'price' => rand(1, 100) * 10,
            'count' => rand(0, 100),
            'vendor_code' => fake()->unique()->numberBetween(0, $this->count),
//            'company_id' => 1,
            'is_published' => 1,
//            'category_id' => 1,
            'preview_image' => mb_substr($this->files_preview_image[array_rand($this->files_preview_image, 1)], 7),
            'created_at' => NOW(),
            'updated_at' => NOW(),
        ];
    }
}
