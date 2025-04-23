<?php

namespace App\Http\Requests;

use App\Models\Category;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            "product_name_en" => 'nullable',
            "unit_id" => 'nullable',
            'code_universal' => [
                'nullable',
                // Rule::unique('products', 'code_universal')
                //     ->where('company_id', $this->company_id)
                //     ->ignore($this->product),
            ],
            "purchasing_price" => 'nullable',
            "wholesale_price" => 'nullable',
            "sector_price" => 'nullable',
            "color" => 'nullable',
            "description" => 'nullable',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'product_pic' => 'nullable|image|mimes:jpg,jpeg,png',
            'first_balance' => [
                'nullable', // Allow it to be null by default
                function ($attribute, $value, $fail) {
                    // Get category_id from input
                    $categoryId = $this->input('category_id');

                    // Retrieve the category name based on category_id
                    $category = Category::find($categoryId);

                    if ($category && $category->name === 'مخزونية' && $value > 0) {
                        if (empty($value)) {
                            $fail('The first_balance field is required when category is مخزونية and value is greater than 0.');
                        }
                    }
                },
            ],
        ];
    }
}
