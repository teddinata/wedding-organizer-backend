<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class StoreOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'vendor_id' => 'required|exists:vendors,id',
            'sales_id' => 'required|exists:sales,id',
            'coordinator_id' => 'required|exists:employees,id',
            'date' => 'required|date',
            'loading_date' => 'required|date',
            'loading_time' => 'required',
            'event_date' => 'required|date',
            'event_time' => 'required',
            'venue' => 'required',
            'room' => 'nullable',
            'coordinator_schedule' => 'nullable',
            // subtotal
            'subtotal' => 'required|integer',
            'discount' => 'required|integer',
            'total' => 'required|integer',
            'order_notes' => 'nullable',
            'is_checklist_tree' => 'nullable',
            'is_checklist_melamin' => 'nullable',
            'is_checklist_lighting' => 'nullable',
            'is_checklist_gazebo' => 'nullable',
            'points' => 'nullable',
            'extra_points' => 'nullable',
            'notes' => 'nullable',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([

            'success'   => false,
            'message'   => 'Validation errors',
            'data'      => $validator->errors()
        ], 422));
    }
}
