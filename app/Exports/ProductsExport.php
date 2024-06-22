<?php

namespace App\Exports;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;

class ProductsExport implements FromCollection
{
    public function collection()
    {
        $company_id = Auth::user()->company_id;
        return Product::select(
            'product_name',
            'wholesale_price',
            'sector_price',
            'first_balance',
            'purchasing_price',
            'unit_id',
            'code_universal',
            'min_balance')
            ->where('company_id', $company_id)->get();
    }
}
