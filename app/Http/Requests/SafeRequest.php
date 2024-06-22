<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SafeRequest extends FormRequest
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
            'safe_name' => 'required',
            'branch_id' => 'required',
            'balance' => 'required',
            'type' => 'required',
        ];
    }
}
