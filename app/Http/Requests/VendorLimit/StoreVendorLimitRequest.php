<?php

namespace App\Http\Requests\VendorLimit;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;

class StoreVendorLimitRequest extends FormRequest
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
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('vendor_limits'), // Pastikan 'name' adalah unik di dalam tabel 'vendor_limits'
            ],
            'amount_limit' => [
                'required',
                'numeric',
                Rule::unique('vendor_limits'), // Pastikan 'amount_limit' adalah unik di dalam tabel 'vendor_limits'
                // Rule::exists('vendor_limits', 'amount_limit')
                //     ->where(function ($query) {
                //         $query->where('amount_limit', '=', $this->input('amount_limit'));
                //     }),
            ],
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
