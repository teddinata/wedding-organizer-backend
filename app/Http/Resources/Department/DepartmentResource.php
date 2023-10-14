<?php

namespace App\Http\Resources\Department;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DepartmentResource extends JsonResource
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
            'payroll_type' => $this->payroll_type,
            'is_has_schedule' => $this->is_has_schedule,
            'clock_in' => $this->clock_in,
            'clock_out' => $this->clock_out,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
