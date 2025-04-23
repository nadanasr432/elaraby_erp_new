<?php

namespace App\Http\Controllers\Client;

use App\Models\Bank;
use App\Models\Cash;
use App\Models\Safe;
use App\Models\Client;
use App\Models\Company;
use App\Models\PosOpen;
use App\Models\Product;
use App\Models\BankCash;
use App\Models\PosReturn;
use App\Models\CouponCash;
use App\Models\PosSetting;
use App\Models\OuterClient;
use Illuminate\Http\Request;
use App\Models\PosReturnElement;
use App\Services\VoucherService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PosReturnController extends Controller
{
    public function returnSpecificPos(Request $request, $pos_id)
    {
        $company_id = Auth::user()->company_id;
        $pos_open = PosOpen::where('id', $pos_id)
            ->where('company_id', $company_id)
            ->with('elements', 'vouchers.transactions', 'outerClient')
            ->first();

        if (!$pos_open) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'الفاتورة المحددة غير موجودة'
                ], 404);
            }
            return redirect()->route('client.pos-returns.index')->with('error', 'الفاتورة المحددة غير موجودة');
        }

        try {
            DB::transaction(function () use ($pos_open, $company_id, $request) {
                $cash_id = "pos_" . $pos_open->id;

                // 1. Create PosReturn record
                $pos_return = PosReturn::create([
                    'pos_open_id' => $pos_open->id,
                    'company_id' => $pos_open->company_id,
                    'client_id' => $pos_open->client_id,
                    'outer_client_id' => $pos_open->outer_client_id,
                    'tableNum' => $pos_open->tableNum,
                    'notes' => $pos_open->notes,
                    'status' => 'returned',
                    'value_added_tax' => $pos_open->value_added_tax,
                    'total_amount' => $pos_open->total_amount,
                    'tax_amount' => $pos_open->tax_amount,
                    'tax_value' => $pos_open->tax_value,
                    // 'company_counter' => $pos_open->company_counter,
                ]);

                // 2. Create PosReturnElement records
                foreach ($pos_open->elements as $element) {
                    PosReturnElement::create([
                        'pos_return_id' => $pos_return->id,
                        'company_id' => $element->company_id,
                        'product_id' => $element->product_id,
                        'product_price' => $element->product_price,
                        'quantity' => $element->quantity,
                        'discount' => $element->discount,
                        'quantity_price' => $element->quantity_price,
                    ]);
                }

                // 3. Handle cash transactions
                $cash = Cash::where('bill_id', $cash_id)->get();
                $cash_amount = 0;
                if (!$cash->isEmpty()) {
                    foreach ($cash as $item) {
                        $cash_amount += $item->amount;
                        $safe = Safe::findOrFail($item->safe_id);
                        $safe->update(['balance' => $safe->balance - $item->amount]);
                        $item->delete();
                    }
                }

                // 4. Handle bank cash
                $bank_cash = BankCash::where('bill_id', $cash_id)->get();
                $cash_bank_amount = 0;
                if (!$bank_cash->isEmpty()) {
                    foreach ($bank_cash as $item) {
                        $cash_bank_amount += $item->amount;
                        $bank = Bank::findOrFail($item->bank_id);
                        $bank->update(['bank_balance' => $bank->bank_balance - $item->amount]);
                        $item->delete();
                    }
                }

                // 5. Handle coupon cash
                $coupon_cash = CouponCash::where('bill_id', $cash_id)->get();
                $cash_coupon_amount = 0;
                if (!$coupon_cash->isEmpty()) {
                    foreach ($coupon_cash as $item) {
                        $cash_coupon_amount += $item->amount;
                        $item->coupon->update(['status' => 'new']);
                        $item->delete();
                    }
                }

                // 6. Restock items
                foreach ($pos_open->elements as $sale_item) {
                    $product = Product::findOrFail($sale_item->product_id);
                    if ($product->category->category_type == 'مخزونية') {
                        $product->update([
                            'first_balance' => $product->first_balance + $sale_item->quantity
                        ]);
                    }
                }

                // 7. Adjust client balance
                $total_paid_amount = $cash_amount + $cash_bank_amount + $cash_coupon_amount;
                $rest = $pos_open->total_amount - $total_paid_amount;
                if ($pos_open->outer_client_id) {
                    $outer_client = OuterClient::findOrFail($pos_open->outer_client_id);
                    $outer_client->update([
                        'prev_balance' => $outer_client->prev_balance - $rest
                    ]);
                }

                // 8. Create reversal vouchers
                $client_account_id = $pos_open->outerClient->accountingTree->id ?? null;
                if ($client_account_id) {
                    // Sales reversal voucher
                    $pos_return->final_total = $pos_open->total_amount;
                    $reversal_voucher = VoucherService::createVoucher(
                        $pos_return,
                        $company_id,
                        'قيد إلغاء فاتورة مبيعات',
                        'cash',
                        1,
                        ['is_reversal' => true]
                    );
                    $reversal_voucher = $pos_return->vouchers()->save($reversal_voucher);

                    // Reverse client account (credit instead of debit)
                    VoucherService::createTransaction(
                        $client_account_id,
                        $reversal_voucher->id,
                        $pos_open->final_total,
                        'دائن من إلغاء فاتورة مبيعات',
                        0 // Credit
                    );

                    // Reverse sales account (debit instead of credit)
                    VoucherService::createTransaction(
                        39, // Sales account ID
                        $reversal_voucher->id,
                        $pos_open->final_total,
                        'مدين من إلغاء فاتورة مبيعات',
                        1 // Debit
                    );

                    // Cost of goods sold reversal (if applicable)
                    $elements = $pos_open->elements;
                    $element_ids = $elements->pluck('product_id');
                    $products = Product::whereIn('id', $element_ids)->with('category')->get();

                    $sum_purchasing_price = $products->reduce(function ($carry, $product) {
                        if ($product->category->category_type != 'خدمية') {
                            return $carry + $product->purchasing_price;
                        }
                        return $carry;
                    }, 0);

                    if ($sum_purchasing_price > 0) {
                        $cost_reversal_voucher = VoucherService::createVoucher(
                            $pos_return,
                            $company_id,
                            'قيد إلغاء تكاليف فاتورة مبيعات',
                            'cash',
                            1,
                            ['is_reversal' => true]
                        );
                        $cost_reversal_voucher = $pos_return->vouchers()->save($cost_reversal_voucher);

                        // Reverse inventory account (credit instead of debit)
                        VoucherService::createTransaction(
                            66, // Inventory account ID
                            $cost_reversal_voucher->id,
                            $sum_purchasing_price,
                            'دائن من إلغاء تكاليف فاتورة مبيعات',
                            0 // Credit
                        );

                        // Reverse cost of goods sold account (debit instead of credit)
                        VoucherService::createTransaction(
                            19, // COGS account ID
                            $cost_reversal_voucher->id,
                            $sum_purchasing_price,
                            'مدين من إلغاء تكاليف فاتورة مبيعات',
                            1 // Debit
                        );
                    }
                }

                // 9. Delete original POS elements (keep vouchers intact)
                $pos_open->elements()->delete();
                $pos_open->delete();
            });

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'تم إلغاء الفاتورة المحددة بنجاح',
                    'redirect' => route('client.pos-returns.index')
                ]);
            }
            return redirect()->route('client.pos-returns.index')->with('success', 'تم إلغاء الفاتورة المحددة بنجاح');
        } catch (\Exception $e) {
            logger($e);
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'حدث خطأ أثناء إلغاء الفاتورة: ' . $e->getMessage()
                ], 500);
            }
            return redirect()->route('client.pos-returns.index')->with('error', 'حدث خطأ أثناء إلغاء الفاتورة: ' . $e->getMessage());
        }
    }

    public function index()
    {
        $company_id = Auth::user()->company_id;
        $pos_returns = PosReturn::where('company_id', $company_id)
            ->with(['outerClient', 'elements'])
            ->latest('returned_at')
            ->get();

        return view('client.pos.returns', compact('pos_returns'));
    }
    public function print($return_id)
    {
        $return = PosReturn::findOrFail($return_id);
        // dd($return);
        // $pos = PosOpen::findOrFail($return->pos_id); // Original POS transaction
        $clientID = $return->client_id;
        $branchID = Client::findOrFail($clientID);
        $company_id = $return->company_id;
        $company = Company::findOrFail($company_id);
        $branchID = $branchID->branch_id;

        if ($branchID) {
            $branchDetails = $return->company->branches->where('id', $branchID)->first();
            $branch_address = $branchDetails->branch_address;
            $branch_phone = $branchDetails->branch_phone;
        } else {
            $branch_address = $return->company->company_address;
            $branch_phone = $return->company->phone_number;
        }

        $posSettings = PosSetting::where("company_id", $return->company_id)->first();

        return view('client.pos.return-print', compact('company', 'return', 'posSettings', 'branch_address', 'branch_phone'));
    }
}
