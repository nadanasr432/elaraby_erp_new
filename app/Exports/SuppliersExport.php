<?php

namespace App\Exports;

use App\Models\Supplier;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;

class SuppliersExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $company_id = Auth::user()->company_id;

        return Supplier::where('company_id', $company_id)
            ->get()
            ->map(function ($supplier) {
                return [
                    'supplier_name'    => $supplier->supplier_name,
                    'supplier_phone'   => optional($supplier->phones->first())->supplier_phone ?? '',
                    'supplier_address' => optional($supplier->addresses->first())->supplier_address ?? '',
                    'tax_number'       => $supplier->tax_number,
                    'prev_balance' => abs(floatval($supplier->prev_balance)),
                ];
            });
    }

    public function headings(): array
    {
        return ['supplier_name', 'supplier_phone', 'supplier_address', 'tax_number', 'prev_balance'];
    }
}
