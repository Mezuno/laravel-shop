<?php

namespace App\Entities\Review\Http\Resources;

use App\Entities\Product\Http\Resources\ProductResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
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
            'user' => $this->user,
            'title' => $this->title,
            'body' => $this->body,
            'rate' => $this->rate,
            'flaws' => $this->flaws,
            'advantages' => $this->advantages,
            'product' => new ProductResource($this->product),
            'created' => date('d F Y, H:i', strtotime($this->created_at)),
        ];
    }
}
