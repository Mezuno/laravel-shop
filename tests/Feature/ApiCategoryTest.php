<?php

namespace Tests\Feature;

use App\Entities\Category\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ApiCategoryTest extends TestCase
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

    public function test_response_for_route_categories_index_is_json_with_categories()
    {
        $this->withoutExceptionHandling();

        $categories = Category::factory(10)->create();

        $response = $this->get('/api/categories');

        $json = $categories->map(function ($category) {
            return [
                'id' => $category->id,
                'title' => $category->title,
            ];
        });

        $json = $json->values()->toArray();

        // Строгое сравнение Json в response
        $response->assertJson(['data' => $json]);
    }
}
