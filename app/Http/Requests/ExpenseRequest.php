<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExpenseRequest extends FormRequest
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
            'expense_number' => 'required',
            'fixed_expense' => 'required',
            'expense_details' => 'required',
            'amount' => 'required',
            'safe_id' => 'nullable|exists:safes,id|required_if:payment_method,cash|required_without:bank_id',
            'bank_id' => 'nullable|exists:banks,id|required_if:payment_method,bank|required_without:safe_id',
            'payment_method' => 'required|string',
            'payment_no' => 'nullable|string',
        ];
    }
    
}
