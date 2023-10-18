<?php

namespace App\Http\Resources\Membership;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MembershipResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'image'         => $this->image,
            'name'          => $this->name,
            'from'          => $this->from,
            'until'         => $this->until,
            'extra_point'   => $this->point,
            'created_at'    => $this->created_at,
            'updated_at'    => $this->updated_at
        ];
    }
}
