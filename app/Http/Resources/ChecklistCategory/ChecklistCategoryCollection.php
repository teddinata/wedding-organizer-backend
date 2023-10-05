<?php

namespace App\Http\Resources\ChecklistCategory;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ChecklistCategoryCollection extends ResourceCollection
{
    //define property
    public $status;
    public $message;

    /**
     * __construct
     *
     * @param  mixed $status
     * @param  mixed $message
     * @param  mixed $resource
     * @return void
     */
    public function __construct($status, $message, $resource)
    {
        parent::__construct($resource);
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
            //'success'   => $this->status,
            //'message'   => $this->message,
            //'data'      => $this->resource->map(function ($category) {
            //return [
            //'id' => $category->id,
            //'name' => $category->name,
            //'created_at' => $category->created_at,
            //];
            //}),
            'success'   => $this->status,
            'message'   => $this->message,
            'data'      => $this->resource
        ];
    }
}
