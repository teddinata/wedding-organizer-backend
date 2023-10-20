<?php

namespace App\Http\Resources\Employee;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeAttendanceResource extends JsonResource
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
            'department_id' => $this->department_id,
            'position_id' => $this->position_id,
            'photo' => $this->photo,
            'employee_number' => $this->employee_number,
            'fullname' => $this->fullname,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
