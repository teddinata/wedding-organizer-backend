<?php

namespace App\Http\Requests\Level;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class StoreLevelRequest extends FormRequest
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
            //'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            // 'name' => 'required|string|min:3|max:255|unique:employee_levels
            // name harus unique di table employee_levels tetapi exclude deleted_at
            'name' => 'required|string|min:3|max:255|unique:employee_levels,name,deleted_at',
            'from' => 'required|numeric',
            'until' => 'required|numeric',
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
