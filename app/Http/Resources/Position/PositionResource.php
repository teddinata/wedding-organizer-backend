<?php

namespace App\Http\Resources\Position;

use App\Http\Resources\CareerLevelResource;
use App\Http\Resources\Department\DepartmentResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PositionResource extends JsonResource
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
            'name' => $this->name,
            'created_at' => $this->created_at,
            'department' => new DepartmentResource($this->whenLoaded('department')),
            'career_level' => new CareerLevelResource($this->whenLoaded('career_level'))
        ];
    }
}
