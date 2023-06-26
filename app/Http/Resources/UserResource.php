<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "message" => "Login success",
            "user" => [
                "name" => $this->name,
                "email" => $this->email,
                "accessToken" => $this->remember_token
            ]
        ];
    }
}
