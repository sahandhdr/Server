<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            "name" => 'nullable',
            "surname" => 'nullable',
            "password" => 'nullable',
            "email" => 'nullable',
            "mobile" => 'nullable',
            "birthday" => 'nullable',
            "gender" => 'nullable',
            "ncode" => 'nullable',
        ];
    }
}
