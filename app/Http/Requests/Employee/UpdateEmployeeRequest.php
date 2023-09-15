<?php

namespace App\Http\Requests\Employee;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class UpdateEmployeeRequest extends FormRequest
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
            'department_id' => 'required|exists:departments,id',
            'position_id' => 'required|exists:positions,id',
            'level_id' => 'required|exists:employee_levels,id',
            'fullname' => 'required|string|max:255',
            'nik' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'password' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'dateofbirth' => 'nullable|date',
            'gender' => 'nullable|in:1,2',
            'ktp_img' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'vaccine_img' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'salary' => 'nullable|numeric',
            'loan_limit' => 'nullable|numeric',
            'active_loan_limit' => 'nullable|numeric',
            'points' => 'nullable|numeric',
            'is_active' => 'nullable|boolean',
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
