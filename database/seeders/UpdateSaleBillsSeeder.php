<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SaleBill;
use App\Models\SaleBillElement;
use App\Models\SaleBillExtra;
use App\Models\Company;
use App\Models\OuterClient;
use App\Models\OuterClientAddress;

class UpdateSaleBillsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $saleBills = SaleBill::where('status', 'done')->get();

        foreach ($saleBills as $saleBill) {
            $elements = SaleBillElement::where('sale_bill_id', $saleBill->id)
                ->where('company_id', $saleBill->company_id)
                ->get();

            if ($elements->isEmpty()) {
                continue;
            }
            // $elements = SaleBillElement::where('sale_bill_id', $saleBill->id)
            // ->where('company_id', $saleBill->company_id)
            // ->whereRaw("CAST(quantity_price AS SIGNED) != quantity_price OR CAST(quantity_price AS DECIMAL(20, 2)) != quantity_price")
            // ->get();
            // dd($elements->pluck('id'));
            $total = $elements->sum(function ($element) {
                return (float) $element->quantity_price;
            });
            $realtotal = $total;

            $shipping = SaleBillExtra::where('sale_bill_id', $saleBill->id)
                ->where('company_id', $saleBill->company_id)
                ->where('action', 'extra')
                ->first();
            $discount = SaleBillExtra::where('sale_bill_id', $saleBill->id)
                ->where('company_id', $saleBill->company_id)
                ->where('action', 'discount')
                ->first();

            $discountValue = 0;
            if ($discount) {
                switch ($discount->action_type) {
                    case 'pound':
                        $discountValue = (float) ($discount->value);
                        $after_discount = (float)$total - $discountValue + ($shipping ? ($shipping->action_type == 'percent' ? $shipping->value / 100 * $total : $shipping->value) : 0);
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
            } else {
                $after_discount = $total;
            }

            $total = $after_discount;

            // Calculate tax
            $company = Company::find($saleBill->company_id);
            $tax_value_added = $company->tax_value_added ?? 15; // Default to 15% if not set
            $sumWithOutTax = $saleBill->value_added_tax ? round($total * 20 / 23, 2) : round($total, 2);
            $sumWithTax = $saleBill->value_added_tax ? $total : round($total + $realtotal * $tax_value_added / 100, 2);
            $totalTax = round($sumWithTax - $sumWithOutTax, 2);

            // Update the SaleBill record
            $saleBill->update([
                'total_discount' => $discountValue,
                'total_tax' => $totalTax,
            ]);
        }
        // Update tax_value for each SaleBillElement
        foreach ($elements as $element) {
            $elementTaxValue = $saleBill->value_added_tax
                ? round($element->quantity_price * $tax_value_added / 100, 2)
                : 0;

            $element->update([
                'tax_value' => $elementTaxValue
            ]);
        }
    }
}
