<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\SaleBill;
use App\Models\SaleBillExtra;
use App\Models\SaleBillElement;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdateSaleBillsSeeder extends Seeder
{
    public function run()
    {
        try {
            DB::transaction(function () {
                // Process the sale bills in chunks to avoid memory issues
                SaleBill::where('status', 'done')
                    ->whereNull('products_discount_type')
                    ->orderBy('company_id')
                    ->orderBy('id', 'desc')
                    ->chunk(500, function ($saleBills) {
                        foreach ($saleBills as $saleBill) {
                            $elements = $saleBill->elements;

                            // Skip if no elements are present
                            if ($elements->isEmpty()) {
                                continue;
                            }

                            // Calculate total from elements
                            $total = $elements->sum(fn($element) => (float) $element->quantity_price);
                            $realtotal = $total;
                            // Fetch shipping and discount details
                            $shipping = SaleBillExtra::where('sale_bill_id', $saleBill->id)
                                ->where('company_id', $saleBill->company_id)
                                ->where('action', 'extra')
                                ->first();

                            $discount = SaleBillExtra::where('sale_bill_id', $saleBill->id)
                                ->where('company_id', $saleBill->company_id)
                                ->where('action', 'discount')
                                ->first();

                            $discountValue = 0;
                            $after_discount = $total;

                            // Handle discount calculations
                            $afterTaxTypes = ['afterTax', 'poundAfterTax', 'poundAfterTaxPercent'];
                            if ($discount) {
                                $discountValue = (float) $discount->value;
                                $shippingValue = $shipping ? (float) $shipping->value : 0;

                                switch ($discount->action_type) {
                                    case 'pound':
                                        $after_discount = $total - $discountValue + ($shipping ? ($shipping->action_type === 'percent' ? $shippingValue / 100 * $total : $shippingValue) : 0);
                                        break;
                                    case 'percent':
                                        $discountValue = $discountValue / 100 * $total;
                                        $after_discount = $total - $discountValue + ($shipping ? ($shipping->action_type === 'percent' ? $shippingValue / 100 * $total : $shippingValue) : 0);
                                        break;
                                    case 'afterTax':
                                        $discountValue = $discountValue / 100 * $total;
                                        $after_discount = $total - $discountValue + ($saleBill->value_added_tax ?? 0);
                                        break;
                                    default:
                                        $after_discount = $total - $discountValue;
                                        break;
                                }
                            }

                            $total = $after_discount;

                            // Calculate tax values based on the company's tax settings
                            $company = Company::find($saleBill->company_id);
                            $tax_value_added = $company->tax_value_added ?? 15; // Default to 15% tax if not specified

                            // Calculate total without tax and total tax
                            $totalTax = $saleBill->value_added_tax
                                ? round(($realtotal * $tax_value_added) / (100 + $tax_value_added), 2)
                                : round(($realtotal * $tax_value_added) / 100, 2);

                            // Update the SaleBill with calculated discount and tax
                            $saleBill->update([
                                'total_discount' => $discountValue,
                                'total_tax' => $totalTax,
                            ]);

                            // Update tax values for each SaleBillElement
                            $fromEveryElement = $discountValue ? $discountValue / $elements->count() : 0;

                            foreach ($elements as $element) {
                                $elementQuantityPrice = $discount && in_array($discount->action_type, $afterTaxTypes)
                                    ? (float)$element->quantity_price
                                    : (float)$element->quantity_price - $fromEveryElement;

                                $elementTaxValue = $saleBill->value_added_tax == 1
                                    ? ((float)$element->quantity_price * (float)$tax_value_added) / (100 + (float)$tax_value_added)
                                    : round((float)$element->quantity_price * (float)$tax_value_added / 100, 2);

                                $element->update([
                                    'tax_value' => $elementTaxValue,
                                    'tax_type' => $saleBill->value_added_tax ? 2 : 0,
                                ]);
                            }
                        }
                    });
            });
        } catch (\Exception $e) {
            Log::error('Error updating sale bill details: ' . $e->getMessage());
        }
    }
}
