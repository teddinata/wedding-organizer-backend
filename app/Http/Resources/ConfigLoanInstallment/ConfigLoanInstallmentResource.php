<?php

namespace App\Http\Resources\ConfigLoanInstallment;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ConfigLoanInstallmentResource extends JsonResource
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
            'nominal' => $this->nominal,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
