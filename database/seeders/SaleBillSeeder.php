<?php

namespace Database\Seeders;

use App\Models\SaleBill;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SaleBillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    $saleBills = SaleBill::select('company_id', 'id')
        ->orderBy('company_id')
        ->orderBy('id')
        ->get()
        ->groupBy('company_id');

    foreach ($saleBills as $companyId => $bills) {
        foreach ($bills as $index => $bill) {
            $bill->sale_bill_number = $index + 1;
            $bill->save();
        }
    }
}

}
