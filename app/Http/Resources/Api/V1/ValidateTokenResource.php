<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ValidateTokenResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'token_id' => $this->id,
            'phone' => sprintf("+7 (xxx) xxx-xx-%s", substr($this->phone, -2)),
        ];
    }
}
