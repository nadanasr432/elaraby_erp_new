<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\SaleBillElement1; // Import the model

class UpdateSaleBillElement1Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Start a database transaction
        DB::beginTransaction();

        try {
            // Retrieve all SaleBillElement1 records
            $saleBillElements = SaleBillElement1::where('discount_value','>',0)->get();
// dd($saleBillElements->toArray());
            foreach ($saleBillElements as $element) {
                // Calculate applied_discount based on your logic
                $discountType = $element->discount_type;  // Assuming you have a discount_type field
                // $quantity = $element->quantity;
                // $unitPrice = $element->unit_price;
                $discountValue = $element->discount_value; // Assuming there's a discount_value field

                // Example calculation (modify based on your logic)
                $totalPrice = $element->quantity_price;
                // Apply the discount based on the discount type (e.g., percent or flat rate)
                if ($discountType === 'percent') {
                    $appliedDiscount = $totalPrice * ($discountValue / 100);
                } else {
                    $appliedDiscount = $discountValue; // For flat-rate discount
                }

                // Update the applied_discount field in the database
                $element->discount_value = $appliedDiscount;
                $element->save();
            }

            // Commit the transaction
            DB::commit();

        } catch (\Exception $e) {
            // Rollback the transaction if an error occurs
            DB::rollBack();
            // Optionally log the error
            Log::error('Error updating applied_discount: ' . $e->getMessage());
        }
    }
}
