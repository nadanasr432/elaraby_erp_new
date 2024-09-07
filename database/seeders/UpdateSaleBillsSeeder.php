<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\SaleBill;
use App\Models\OuterClient;
use App\Models\SaleBillExtra;
use App\Models\SaleBillElement;
use Illuminate\Database\Seeder;
use App\Models\OuterClientAddress;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdateSaleBillsSeeder extends Seeder
{

    public function run()
    {
        $saleBills = SaleBill::where('status', 'done')->get();

        try {
            DB::transaction(function () {
                // Fetch sale bills as per your previous implementation
                $saleBills = SaleBill::select('company_id', 'id')
                    ->orderBy('company_id')
                    ->orderBy('id')
                    ->get();

                foreach ($saleBills as $saleBill) {
                    $elements = SaleBillElement::where('sale_bill_id', $saleBill->id)
                        ->where('company_id', $saleBill->company_id)
                        ->get();

                    if ($elements->isEmpty()) {
                        continue;
                    }

                    // Calculate total based on element prices
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

                    // Handle discount calculations based on action type
                    if ($discount) {
                        switch ($discount->action_type) {
                            case 'pound':
                                $discountValue = (float) $discount->value;
                                $after_discount = $total - $discountValue + ($shipping ? ($shipping->action_type == 'percent' ? $shipping->value / 100 * $total : $shipping->value) : 0);
                                break;
                            case 'percent':
                                $discountValue = $discount->value / 100 * $total;
                                $after_discount = $total - $discountValue + ($shipping ? ($shipping->action_type == 'percent' ? $shipping->value / 100 * $total : $shipping->value) : 0);
                                break;
                            case 'afterTax':
                                $discountValue = $discount->value / 100 * $total;
                                $after_discount = $total - $discountValue + ($saleBill->value_added_tax ? $saleBill->value_added_tax : 0);
                                break;
                            case 'poundAfterTax':
                                $discountValue = $discount->value - $total;
                                $after_discount = $total - $discountValue;
                                break;
                            case 'poundAfterTaxPercent':
                                $discountValue = ($discount->value * $total) / 100;
                                $after_discount = $total - $discountValue;
                                break;
                            default:
                                $after_discount = $total - $discount->value;
                                break;
                        }
                    }

                    $total = $after_discount;

                    // Calculate tax values based on the company's tax settings
                    $company = Company::find($saleBill->company_id);
                    $tax_value_added = $company->tax_value_added ?? 15; // Default tax percentage if not specified

                    // Calculate totals with and without tax
                    $sumWithOutTax = $saleBill->value_added_tax ? round($total * 20 / 23, 2) : round($total, 2);
                    $sumWithTax = $saleBill->value_added_tax ? $total : round($total + $realtotal * $tax_value_added / 100, 2);
                    $totalTax = round($sumWithTax - $sumWithOutTax, 2);

                    // Update the SaleBill with the calculated discount and tax
                    $saleBill->update([
                        'total_discount' => $discountValue,
                        'total_tax' => $totalTax,
                    ]);

                    // Update tax values for each SaleBillElement
                    foreach ($elements as $element) {
                        $elementTaxValue = $saleBill->value_added_tax
                            ? round($element->quantity_price * $tax_value_added / 100, 2)
                            : 0;

                        $element->update([
                            'tax_value' => $elementTaxValue,
                            'tax_type' => $saleBill->value_added_tax,
                        ]);
                    }
                }
            });
        } catch (\Exception $e) {
            // Handle any exceptions, log them, and possibly re-throw if needed
            Log::error('Error updating sale bill details: ' . $e->getMessage());
            throw $e;
        }
    }
}
