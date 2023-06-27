<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StoreQuestionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "message" => "Add questions success",
            "question" => [
                "name" => $this->name,
                "choice_type" => $this->choice_type,
                "is_required" => $this->is_required,
                "choices" => $this->choices,
                "form_id" => $this->form_id,
                "id" => $this->id,
            ]
        ];
    }
}
