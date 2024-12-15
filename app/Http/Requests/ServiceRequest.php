<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest
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
            'category_id' => 'required',
            "company_id" => 'required',
            "sub_category_id" => 'nullable',
            "product_model" => 'nullable',
            "product_name" => 'required',
            "product_name_en"=>'nullable',
            "unit_id" => 'nullable',
            'code_universal' => [
                'nullable',
                Rule::unique('products', 'code_universal')
                    ->where('company_id', $this->company_id)
                    ->ignore($this->product), // Handles the update scenario
            ],
            "wholesale_price" => 'nullable',
            "sector_price" => 'nullable',
            "color" => 'nullable',
            "description" => 'nullable',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ];
    }
}
