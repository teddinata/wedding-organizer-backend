<?php

namespace App\Http\Resources\ProductVariant;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductVariantCollection extends ResourceCollection
{
    //define property
    public $status;
    public $message;

    /**
     * __construct
     *
     * @param  mixed $status
     * @param  mixed $message
     * @param  mixed $collection
     * @return void
     */
    public function __construct($status, $message, $collection)
    {
        parent::__construct($collection);
        $this->status  = $status;
        $this->message = $message;
    }

    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'success'   => $this->status,
            'message'   => $this->message,
            'data'      => $this->collection
        ];
    }
}
