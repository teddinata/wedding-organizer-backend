<?php

namespace App\Http\Resources\BankAccount;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BankAccountResource extends JsonResource
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
            'bank' => $this->bank,
            'account_holder' => $this->account_holder,
            'account_number' => $this->account_number,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
            //'created_at' => date_format($this->created_at, "Y/m/d H:i:s")
        ];
    }
}
