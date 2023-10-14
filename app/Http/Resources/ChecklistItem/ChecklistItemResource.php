<?php

namespace App\Http\Resources\ChecklistItem;

use App\Http\Resources\ChecklistCategory\ChecklistCategoryResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChecklistItemResource extends JsonResource
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
            'updated_at' => $this->updated_at,
            'checklist_category' => new ChecklistCategoryResource($this->whenLoaded('checklist_category'))
        ];
    }
}
