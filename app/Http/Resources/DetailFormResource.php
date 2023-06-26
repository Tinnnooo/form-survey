<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DetailFormResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "message" => "Get form success",
            "form" => [
                "id" => $this->id,
                "name" => $this->name,
                "slug" => $this->slug,
                "description" => $this->slug,
                "limit_one_response" => $this->limit_one_response,
                "creator_id" => $this->creator_id,
                "allowed_domains" => $this->allowedDomains
            ]
        ];
    }
}
