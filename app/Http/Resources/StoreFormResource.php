<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StoreFormResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'message' => 'Create form success',
            'form' => [
                'name' => $this->name,
                'slug' => $this->slug,
                'description' => $this->description,
                'limit_one_response' => $this->limit_one_response,
                'creator_id' => $this->creator_id,
                'id' => $this->id,
            ],
        ];
    }
}
