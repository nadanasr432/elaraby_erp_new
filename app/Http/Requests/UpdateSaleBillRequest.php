<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSaleBillRequest extends FormRequest
{
    public function authorize()
    {
        // You can handle authorization logic here if needed, otherwise return true
        return true;
    }

    public function rules()
    {
        return [
            'sale_bill_number' => 'required|exists:sale_bills,sale_bill_number',
            'company_id' => 'required|exists:companies,id',
            'outer_client_id' => 'required|exists:outer_clients,id',
            'store_id' => 'required|exists:stores,id',
            'date' => 'required|date',
            'time' => 'required',
            'main_notes' => 'nullable|string',
            'grand_total' => 'required|numeric|min:0',
            'total_discount' => 'nullable|numeric|min:0',
            'grand_tax' => 'nullable|numeric|min:0',
            'products_discount_type' => 'nullable|string',
            'value_added_tax' => 'nullable|boolean',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.product_price' => 'required|numeric|min:0',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.unit_id' => 'required|exists:units,id',
            'products.*.tax_amount' => 'nullable|numeric|min:0',
            'products.*.discount' => 'nullable|numeric|min:0',
            'products.*.tax' => 'nullable|string',
            'products.*.price_type' => 'nullable|string',
            'products.*.discount_type' => 'nullable|string',
            'discount_type' => 'nullable|string',
            'discount_value' => 'nullable|numeric|min:0',
            'discount_note' => 'nullable|string',
            'extra_type' => 'nullable|string',
            'extra_value' => 'nullable|numeric|min:0',
            'amount' => 'nullable|numeric|min:0',
            'payment_method' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'sale_bill_number.required' => 'رقم الفاتورة مطلوب.',
            'company_id.required' => 'رقم الشركة مطلوب.',
            'outer_client_id.required' => 'رقم العميل مطلوب.',
            'store_id.required' => 'رقم المخزن مطلوب.',
            'date.required' => 'تاريخ الفاتورة مطلوب.',
            'grand_total.required' => 'إجمالي الفاتورة مطلوب.',
            'grand_total.numeric' => 'إجمالي الفاتورة يجب أن يكون رقماً.',
            'products.*.product_id.required' => 'رقم المنتج مطلوب لكل عنصر.',
            'products.*.product_price.required' => 'سعر المنتج مطلوب.',
            'products.*.quantity.required' => 'الكمية مطلوبة لكل منتج.',
            'products.*.unit_id.required' => 'وحدة المنتج مطلوبة.',
            // 'products.*.price_type.required' => 'نوع سعر المنتج مطلوب.',
        ];
    }
}
