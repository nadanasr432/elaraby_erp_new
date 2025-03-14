<?php

namespace App\Services;

use Exception;
use App\Models\ProductStock;
use Illuminate\Support\Facades\Auth;

class StockService
{
    public static function reduce($product, $storeId, $cumulative = 1, $return = null)
    {
        $type = $product->product?->category ? $product->product->category->category_type : $product->category->category_type;
        $company_id = Auth::user()->company_id;
        $any = ProductStock::where(['product_id' => $product->product_id ?? $product->id, "store_id" => $storeId, 'company_id' => $company_id])
            ->where('remaining', '>', 0)
            ->select(['id', 'net_unit_cost', 'remaining', 'product_id'])
            ->oldest()->get();
        logger($any);
        // logger($product);
        // logger($product->product_id);
        ProductStock::where(['product_id' => $product->product_id ?? $product->id, "store_id" => $storeId, 'company_id' => $company_id])
            ->where('remaining', '>', 0)
            ->select(['id', 'net_unit_cost', 'remaining', 'product_id'])
            ->oldest()
            ->each(function ($productStock) use (&$cumulative) {
                $productStock = (object) $productStock;
                if ($cumulative <= 0) {
                    return;
                }
                $remaining = $productStock->remaining - $cumulative <= 0 ?
                    $productStock->remaining :
                    $cumulative;
                $cumulative -= $remaining;
                $productStock->update([
                    'remaining' => $productStock->remaining - $remaining,
                ]);
            });

        $product = $product->product ?? $product;
        if ($cumulative > 0 && $type != 'خدمية') {

            throw new \ValueError(trans('sales_bills.Product qty executed', ['product' => $product?->name ?? $product->product_unit_name]));
        };
    }
    public static function record($product, $storeId, $remaining, $company_id = null)
    {
        $company_id = $company_id ?? Auth::user()->company_id;
        ProductStock::create([
            'product_id'     => $product->product_id ?? $product->id,
            'store_id'       => $storeId,
            'remaining'      => $remaining,
            'qty'            => $product->quantity ?? $remaining,
            'stockable_id'   => $product->id ?? $product->product_id,
            'stockable_type' => get_class($product),
            'net_unit_cost'  => $product->product_price ?? $product->price ?? $product->cost ?? $product->purchasing_price,
            'company_id'     => $company_id,
        ]);
    }
    public static function getTotalCost($product_data, $qty = 1): float
    {
        $cumulative = $qty;
        $id = $product_data->product_id ?? $product_data->id;
        $type = $product_data->category?->category_type ?? $product_data->product?->category->category_type;
        $purchase_subtotal = 0;
        $company_id = Auth::user()->company_id;
        $lastCost = 0;
        $product_data->manufacture = $product_data->product->manufacture ?? $product_data->manufacture;
        if ($type == 'مجمع' && $product_data->manufacture == 0) {
            ProductStock::where('product_id', $id)
                ->where('remaining', '>', 0)
                ->where('company_id', $company_id)
                ->when($product_data->store_id, fn($p) => $p->where('store_id', $product_data->store_id))
                ->select(['id', 'net_unit_cost', 'remaining', 'product_id'])
                ->oldest()
                ->each(function (ProductStock $product_stock) use (&$cumulative, &$purchase_subtotal, &$product_data) {
                    if ($cumulative <= 0) {
                        return;
                    }
                    $remaining = $product_stock->remaining - ($cumulative) <= 0
                        ? $product_stock->remaining
                        : $cumulative;
                    $cumulative -= $remaining;
                    $purchase_subtotal += $remaining * ($product_stock->net_unit_cost);
                    $lastCost = $product_stock->net_unit_cost;

                    if ($remaining <= 0) {
                        return;
                    }
                });
        } elseif ($type != 'خدمية') {
            ProductStock::where('product_id', $id)
                ->when($product_data->store_id, fn($p) => $p->where('store_id', $product_data->store_id))
                ->where('remaining', '>', 0)
                ->select(['id', 'net_unit_cost', 'remaining'])
                ->oldest()
                ->each(function (ProductStock $productStock) use (&$cumulative, &$purchase_subtotal) {
                    if ($cumulative <= 0) {
                        return;
                    }
                    $remaining = $productStock->remaining - $cumulative <= 0 ?
                        $productStock->remaining :
                        $cumulative;
                    $purchase_subtotal += $remaining * $productStock->net_unit_cost;
                    $cumulative -= $remaining;
                    $lastCost = $productStock->net_unit_cost;
                });
        };
        if ($cumulative > 0 && $type != 'خدمية') {
            // throw new Exception(trans("sales_bills.Product qty executed".$product_data->product->name, ['product' => $product_data->product->name]));
            return $purchase_subtotal  + ($cumulative * $lastCost);
        };
        return $purchase_subtotal;
    }
}
