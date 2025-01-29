<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class UserRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|unique:users,name',
            'initial_balance' => 'required|numeric|min:0',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        // Automatically returns a JSON response with validation errors
        throw new HttpResponseException(
            response()->json($validator->errors(), 422)
        );
    }
}
