<?php

namespace App\Imports;

use App\Models\Company;
use App\Models\Supplier;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;

class SuppliersImport implements ToModel, WithHeadingRow, WithBatchInserts
{
    public function model(array $row)
    {
        $company_id = auth()->user()->company_id;

        $suppliers = Supplier::where('company_id', $company_id)->get();
        
        // Check if any supplier has a non-zero balance
        // if ($suppliers->where('prev_balance', '!=', 0)->isNotEmpty()) {
        //     return redirect()->route('client.suppliers.index')
        //         ->with('error', 'بعض الموردين لديهم مستحقات من فواتير سابقة');
        // }
        
        // Proceed to delete all related data and the suppliers
        // foreach ($suppliers as $supplier) {
        //     $supplier->phones()->delete();
        //     $supplier->notes()->delete();
        //     $supplier->addresses()->delete();
        //     $supplier->delete();
        // }
        $now = now();

        return new Supplier([
            'company_id'        => $company_id,
            'supplier_name'     => $row['supplier_name'],
            'supplier_category' => 'جملة',
            'supplier_phone'    => $row['supplier_phone'],
            'supplier_address'  => $row['supplier_address'],
            'tax_number'        => $row['tax_number'],
            'prev_balance'      => floatval($row['prev_balance']),
            'created_at'        => $now,
            'updated_at'        => $now,
        ]);
    }

    public function batchSize(): int
    {
        return 1000;
    }
}

