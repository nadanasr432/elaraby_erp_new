<?php

namespace App\Exports;
use App\Models\Supplier;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;

class SuppliersExport implements FromCollection
{
    public function collection()
    {
        $company_id = Auth::user()->company_id;
        return Supplier::select('supplier_name','prev_balance')
            ->where('company_id', $company_id)->get();
    }
}
