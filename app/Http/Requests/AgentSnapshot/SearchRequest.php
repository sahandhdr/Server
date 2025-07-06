<?php

namespace App\Http\Requests\AgentSnapshot;

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
            "agent_id" => 'nullable|exists:agents,id',
            "cpu" => 'nullable',
            "ram" => 'nullable',
            "disk" => 'nullable',
            "network" => 'nullable',
        ];
    }
}
