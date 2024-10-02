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

class UpdateSaleBillsSeeder1 extends Seeder
{

    public function run()
    {
        $saleBills = SaleBill::where('status', 'done')->where('total_tax', 0)->get();

        try {
            DB::transaction(function () {
                // Fetch sale bills as per your previous implementation
                // $saleBills = SaleBill::where('status', 'done')->where('total_tax', 0)
                $saleBills = SaleBill::where('status', 'done')->whereNull('products_discount_type')
                    // ->select('company_id', 'id')
                    ->orderBy('company_id')
                    ->orderBy('id', 'desc')
                    ->get();
                foreach ($saleBills as $saleBill) {
                    $elements = $saleBill->elements;
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
                    $afterTax = ['afterTax', 'poundAfterTax', 'poundAfterTaxPercent'];
                    if ($discount) {
                        $discountValue = (float) $discount->value;
                        $shippingValue = $shipping ? (float) $shipping->value : 0;
                        switch ($discount->action_type) {
                            case 'pound':
                                $after_discount = $total - $discountValue + ($shipping ? ($shipping->action_type == 'percent' ? $shippingValue / 100 * $total : $shippingValue) : 0);
                                break;
                            case 'percent':
                                $discountValue = $discountValue / 100 * $total;
                                $after_discount = $total - $discountValue + ($shipping ? ($shipping->action_type == 'percent' ? $shippingValue / 100 * $total : $shippingValue) : 0);
                                break;
                            case 'afterTax':
                                $discountValue = $discountValue / 100 * $total;
                                $after_discount = $total - $discountValue + ($saleBill->value_added_tax ? $saleBill->value_added_tax : 0);
                                break;
                            case 'poundAfterTax':
                                $after_discount = $total;
                                break;
                            case 'poundAfterTaxPercent':
                                // $discountValue = ($discountValue * $total) / 100;
                                $after_discount = $total;
                                break;
                            default:
                                $after_discount = $total - $discountValue;
                                break;
                        }
                    }

                    $total = $after_discount;

                    // Calculate tax values based on the company's tax settings
                    $company = Company::find($saleBill->company_id);
                    $tax_value_added = $company->tax_value_added ?? 15; // Default tax percentage if not specified

                    // Calculate totals with and without tax
                    $sumWithOutTax = $saleBill->value_added_tax ? round(($total * $tax_value_added) / (100 + $tax_value_added), 2) : round($total + ($total * $tax_value_added / 100), 2);
                    $sumWithTax = $saleBill->value_added_tax ? $total : round($total + $total * $tax_value_added / 100, 2);
                    // $totalTax = round($sumWithTax - $sumWithOutTax, 2);
                    $totalTax = $saleBill->value_added_tax ? round(($realtotal * $tax_value_added) / (100 + $tax_value_added), 2) : round(($realtotal * $tax_value_added / 100), 2);

                    // $totalTax = $saleBill->value_added_tax == 1
                    //     ? ($realtotal * $tax_value_added) / (100 + $tax_value_added)
                    //     : round($realtotal * $tax_value_added / 100, 2);

                    // Update the SaleBill with the calculated discount and tax
                    $saleBill->update([
                        'total_discount' => $discountValue,
                        'total_tax' => $totalTax,
                    ]);

                    // Update tax values for each SaleBillElement
                    $fromEveryElement = $discountValue ? $discountValue / count($elements) : 0;
                    foreach ($elements as $element) {
                        $elementQuantityPrice = $discount && in_array($discount->action_type, $afterTax) ? (float)$element->quantity_price : (float)$element->quantity_price - $fromEveryElement;
                        // $elementTaxValue = $saleBill->value_added_tax == 1
                        //     ? ($elementQuantityPrice * $tax_value_added) / (100 + $tax_value_added)
                        //     : round((float)($elementQuantityPrice) * (float)$tax_value_added / 100, 2);
                        $elementTaxValue = $saleBill->value_added_tax == 1
                            ? ((float)$element->quantity_price * $tax_value_added) / (100 + $tax_value_added)
                            : round((float)($element->quantity_price) * (float)$tax_value_added / 100, 2);

                        $element->update([
                            'tax_value' => $elementTaxValue,
                            'tax_type' => $saleBill->value_added_tax == 1 ? 2 : 0,
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
