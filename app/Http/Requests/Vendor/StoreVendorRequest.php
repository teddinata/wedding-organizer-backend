<?php

namespace App\Http\Requests\Vendor;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class StoreVendorRequest extends FormRequest
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
            'name' => ['required'],
            'vendor_grade_id' => ['required'],
            'vendor_limit_id' => ['required'],
            'membership_id' => ['required'],
            'code' => ['required'],
            'name' => ['required'],
            // email harus unique di table vendor tetapi exclude deleted_at
            'email' => ['required', 'email', 'unique:vendors,email,' . $this->id . ',id,deleted_at,NULL'],
            'point' => 'nullable|integer',
            'contact_number' => ['required'],
            'contact_person' => ['required'],
            'website' => ['required'],
            'instagram' => ['required'],
            'address' => ['required'],
            'city' => ['required'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([

            'success'   => false,
            'message'   => 'Validation errors',
            'data'      => $validator->errors()
        ], 422));
    }
}
