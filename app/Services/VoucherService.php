<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Voucher;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class VoucherService
{
    public static function createTransaction($accountingTreeId, $voucherId, $amount, $notation, $type)
    {
        return Transaction::updateOrCreate(
            [
                'accounting_tree_id' => $accountingTreeId,
                'voucher_id' => $voucherId,
            ],
            [
                'amount' => $amount,
                'notation' => $notation,
                'type' => $type,
                'company_id' => Auth::user()->company_id,
            ]
        );
    }

    public static function createVoucher($saleBill, $companyId, $notation, $paymentMethod = "deferred", $status = 1, $options = 1)
    {
        return Voucher::updateOrCreate(
            [
                'amount' => $saleBill->final_total,
                'company_id' => $companyId,
                'user_id' => Auth::user()->id,
            ],
            [
                'date' => Carbon::now(),
                'payment_method' => $paymentMethod,
                'notation' => $notation,
                'status' => $status,
                'options' => $options,
            ]
        );
    }
}
