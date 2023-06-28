<?php

namespace Tests\Feature;

use App\Entities\Product\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ApiProductTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('fake_storage');
        $this->withHeaders([
            'accept' => 'application/json',
        ]);
    }

    public function test_response_for_route_product_show_is_json_with_single_product(): void
    {
        $this->withoutExceptionHandling();

        $product = Product::factory()->create();

        $response = $this->get('/api/products/' . $product->id);

        $response
            ->assertJson([ 'data' => [
                'id' => $product->id,
                'title' => $product->title,
                'description' => $product->description,
                'image_url' => $product->image_url,
                'price' => $product->price . '.00',
                'count' => $product->count,
                'avg_rate' => sprintf("%.1f", $product->review()->avg('rate')),
                'reviews_count' => $product->review()->count(),
            ]]);
    }

    public function test_response_for_route_products_index_is_json_with_products()
    {
        $this->withoutExceptionHandling();

        $products = Product::factory(10)->create();

        $response = $this->get('/api/products');

        $json = $products->map(function ($product) {
            return [
                'id' => $product->id,
                'title' => $product->title,
                'description' => $product->description,
                'image_url' => $product->image_url,
            ];
        });

        $json = $json->sortByDesc('id')->values()->toArray();

        // Строгое сравнение Json в response
        $response->assertJson(['data' => $json]);
    }
}
