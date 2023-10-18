<?php

namespace App\Http\Resources\Attendance;

use App\Http\Resources\Employee\EmployeeAttendanceResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceResource extends JsonResource
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
            'date' => $this->date,
            'clock_in' => $this->clock_in,
            'clock_in_photo' => $this->clock_in_photo,
            'clock_in_location' => $this->clock_in_location,
            'clock_in_address' => $this->clock_in_address,
            'clock_out' => $this->clock_out,
            'clock_out_photo' => $this->clock_out_photo,
            'clock_out_location' => $this->clock_out_location,
            'clock_out_address' => $this->clock_out_address,
            'status' => $this->status,
            'platform' => $this->platform,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'employee' => new EmployeeAttendanceResource($this->whenLoaded('employee'))
        ];
    }
}
