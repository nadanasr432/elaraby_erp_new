<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePurchaseOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Change this based on your authorization logic.
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'supplier_id' => 'required|exists:suppliers,id',
            'start_date' => 'required|date',
            'expiration_date' => 'required|date|after_or_equal:start_date',
            'store_id' => 'required|exists:stores,id',
            'product_id' => 'required|exists:products,id',
            'product_price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1',
            'unit_id' => 'required|exists:units,id',
            'quantity_price' => 'required|numeric|min:0',
        ];
    }

    /**
     * Get custom error messages for validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'supplier_id.required' => 'The supplier field is required.',
            'supplier_id.exists' => 'The selected supplier does not exist.',
            'start_date.required' => 'The start date field is required.',
            'start_date.date' => 'The start date must be a valid date.',
            'expiration_date.required' => 'The expiration date field is required.',
            'expiration_date.date' => 'The expiration date must be a valid date.',
            'expiration_date.after_or_equal' => 'The expiration date must be after or equal to the start date.',
            'store_id.required' => 'The store field is required.',
            'store_id.exists' => 'The selected store does not exist.',
            'product_id.required' => 'The product field is required.',
            'product_id.exists' => 'The selected product does not exist.',
            'product_price.required' => 'The product price field is required.',
            'product_price.numeric' => 'The product price must be a valid number.',
            'product_price.min' => 'The product price must be at least 0.',
            'quantity.required' => 'The quantity field is required.',
            'quantity.integer' => 'The quantity must be a valid number.',
            'quantity.min' => 'The quantity must be at least 1.',
            'unit_id.required' => 'The unit field is required.',
            'unit_id.exists' => 'The selected unit does not exist.',
            'quantity_price.required' => 'The quantity price field is required.',
            'quantity_price.numeric' => 'The quantity price must be a valid number.',
            'quantity_price.min' => 'The quantity price must be at least 0.',
        ];
    }
}
