<?php

namespace Database\Seeders;

use App\Models\SaleBill;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SaleBillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            DB::transaction(function () {
                // Retrieve and group sale bills by company_id, ordered by company_id and id
                $saleBills = SaleBill::select('company_id', 'id')
                    ->orderBy('company_id')
                    ->orderBy('id')
                    ->get()
                    ->groupBy('company_id');

                // Iterate through each group of sale bills by company
                foreach ($saleBills as $companyId => $bills) {
                    // Initialize the sale_bill_number starting from 1 for each company_id
                    $saleBillNumber = 1;

                    // Ensure bills are processed in order of their IDs
                    $bills = $bills->sortBy('id');

                    foreach ($bills as $bill) {
                        // Update sale_bill_number to ensure it increments correctly
                        $bill->sale_bill_number = $saleBillNumber;
                        $bill->save();

                        // Increment sale_bill_number for the next bill
                        $saleBillNumber++;
                    }
                }
            });
        } catch (\Exception $e) {
            // Log the error and handle exceptions if any issues occur during the transaction
            Log::error('Failed to update sale bill numbers: ' . $e->getMessage());
            throw $e; // Re-throw the exception if necessary
        }
    }
}
