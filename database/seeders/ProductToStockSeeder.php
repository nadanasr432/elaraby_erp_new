<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Services\StockService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductToStockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productsToStock = Product::where('first_balance', '>', 0)->where('purchasing_price', '>', 0)->whereNotNull('purchasing_price')->whereHas('category', function ($query) {
            $query->where('category_type', 'مخزونية');
        })->get();
        DB::transaction(function () use ($productsToStock) {
            foreach ($productsToStock as $product) {
                StockService::record($product, $product->store_id, $product->first_balance, $product->company_id);
            }
        });
    }
}
