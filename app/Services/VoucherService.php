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
        return Transaction::create([
            'accounting_tree_id' => $accountingTreeId,
            'voucher_id' => $voucherId,
            'amount' => $amount,
            'notation' => $notation,
            'type' => $type,
        ]);
    }
    public static function createVoucher($saleBill, $companyId, $notation, $paymentMethod = "cash", $status = 1, $options = 1)
    {
        return new Voucher([
            'amount' => $saleBill->final_total,
            'company_id' => $companyId,
            'date' => Carbon::now(),
            'payment_method' => $paymentMethod,
            'notation' => $notation,
            'status' => $status,
            'user_id' => Auth::user()->id,
            'options' => $options,
        ]);
    }
}
