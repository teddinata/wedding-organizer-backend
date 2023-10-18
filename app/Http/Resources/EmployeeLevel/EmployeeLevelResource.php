<?php

namespace App\Http\Resources\EmployeeLevel;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeLevelResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'icon'       => $this->icon,
            'name'       => $this->name,
            'from'       => $this->from,
            'until'      => $this->until,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
