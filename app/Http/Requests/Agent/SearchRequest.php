<?php

namespace App\Http\Requests\Agent;

use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
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
            "hostname" => 'nullable',
            "ip_address" => 'nullable',
            "os" => 'nullable',
            "os_version" => 'nullable',
            "mac_address" => 'nullable',
            "boot_time" => 'nullable',
            "status" => 'nullable',
            "dept_id" => 'nullable',
            "search" => 'nullable',
        ];
    }
}
