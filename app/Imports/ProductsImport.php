<?php

namespace App\Imports;

use App\Models\Company;
use App\Models\Product;
use App\Models\Unit;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;

class ProductsImport implements ToModel, WithBatchInserts, SkipsEmptyRows
{
    public function model(array $row)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $store_id = $company->stores[0]->id;
        $category_id = $company->categories[0]->id;
        $now = date("Y-m-d H:i:s");
        $units = Unit::where('company_id', $company_id)->count();

        // Ensure the necessary array keys exist and provide default values if they don't
        $product_name = $row[0] ?? null;
        $wholesale_price = $row[1] ?? 0;
        $sector_price = $row[2] ?? 0;
        $first_balance = $row[3] ?? 0;
        $purchasing_price = $row[4] ?? 0;
        $code_universal = $row[5] ?? '';
        $min_balance = $row[6] ?? 2; // Default minimum balance if not provided

        if ($units != 0) {
            $unitID = Unit::where('company_id', $company_id)->first()->id;
            return new Product([
                'company_id' => $company_id,
                'store_id' => $store_id,
                'category_id' => $category_id,
                'product_name' => $product_name,
                'wholesale_price' => $wholesale_price,
                'sector_price' => $sector_price,
                'first_balance' => $first_balance,
                'purchasing_price' => $purchasing_price,
                'code_universal' => $code_universal,
                'min_balance' => 2,
                'unit_id' => $unitID,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        } else {
            return new Product([
                'company_id' => $company_id,
                'store_id' => $store_id,
                'category_id' => $category_id,
                'product_name' => $product_name,
                'wholesale_price' => $wholesale_price,
                'sector_price' => $sector_price,
                'first_balance' => $first_balance,
                'purchasing_price' => $purchasing_price,
                'code_universal' => $code_universal,
                'min_balance' => $min_balance,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    public function batchSize(): int
    {
        return 1600;
    }
}
