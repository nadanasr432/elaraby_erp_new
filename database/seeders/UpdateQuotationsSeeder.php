<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\QuotationElement;
use App\Models\SaleBill;
use App\Models\SaleBillExtra;
use App\Models\SaleBillElement;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdateQuotationsSeeder extends Seeder
{
    public function run()
    {
        try {
            DB::transaction(function () {
                $quotationsElements = QuotationElement::all();
                foreach ($quotationsElements as $element) {
                    $quantityPrice = (float)$element->product_price * (float)$element->quantity;
                    $element->quantity_price = $quantityPrice;
                    $element->save();
                }
            });
        } catch (\Exception $e) {
            Log::error('Error updating sale bill details: ' . $e->getMessage());
        }
    }
}
