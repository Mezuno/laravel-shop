<?php

namespace App\Entities\Product\Http\Resources;

use App\Entities\Category\Http\Resources\CategoryResource;
use App\Entities\Tag\Http\Resources\TagResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'content' => $this->content,
            'image_url' => $this->imageUrl,
            'product_images' => ProductImageResource::collection($this->productImages),
            'vendor_code' => $this->vendor_code,
            'price' => $this->price,
            'count' => $this->count,
            'category' => new CategoryResource($this->category),
            'tags' => TagResource::collection($this->tags),
        ];
    }
}
