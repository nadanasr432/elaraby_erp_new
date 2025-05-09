<?php

namespace App\Listeners;

use App\Models\SaleBill1;
use Illuminate\Support\Str;
use App\Services\ZatcaService;
use App\Events\SaleBillCreated;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProcessSaleBillZatca implements ShouldQueue
{
    protected $zatcaService;

    public function __construct(ZatcaService $zatcaService)
    {
        $this->zatcaService = $zatcaService;
    }

    public function handle(SaleBillCreated $event)
    {
        static $callCount = 0;
        $saleBill = $event->saleBill;
        Log::debug('ProcessSaleBillZatca called', [
            'saleBillId' => $saleBill->id,
            'callCount' => ++$callCount,
            'timestamp' => now()->toDateTimeString(),
        ]);

        if ($saleBill->zatca_status === 'sent') {
            Log::info('SaleBill already sent to ZATCA', ['saleBillId' => $saleBill->id]);
            return;
        }
        try {
            Log::info('Preparing to send SaleBill to ZATCA', ['saleBillId' => $saleBill->id]);

            $saleBill->load(['company', 'client', 'outerClient', 'elements', 'extras']);

            if (!$saleBill->company) {
                Log::error('Company relation missing', ['saleBillId' => $saleBill->id]);
                $saleBill->update(['zatca_status' => 'failed', 'zatca_error' => 'Company relation missing']);
                return;
            }

            if ($saleBill->elements->isEmpty()) {
                Log::error('No items found for SaleBill', ['saleBillId' => $saleBill->id]);
                $saleBill->update(['zatca_status' => 'failed', 'zatca_error' => 'No items found']);
                return;
            }

            $companyOnboardingData = $saleBill->company->onboarding_data;
            if (empty($companyOnboardingData) || base64_decode($companyOnboardingData, true) === false) {
                Log::error('Invalid onboarding data', ['saleBillId' => $saleBill->id]);
                $saleBill->update(['zatca_status' => 'failed', 'zatca_error' => 'Invalid onboarding data']);
                return;
            }

            $bill = [
                'bill_type' => ZatcaService::BILL_TYPE_INVOICE,
                'reference_number' => $saleBill->sale_bill_number ?? 'UNDEFINED_' . $saleBill->id,
                'uuid' => $saleBill->uuid ?? Str::uuid()->toString(),
                'currency' => 'SAR',
                'is_simplified' => true,
                'seller_info' => [
                    'name' => $saleBill->company->company_name ?? 'الزهور',
                    'id' => $saleBill->company->crn ?? '151001111111113',
                    'id_type' => 'CRN',
                    'country' => 'SA',
                    'address' => [
                        'street' => $saleBill->company->address_street ?? 'Prince Naif Street',
                        'building_number' => $saleBill->company->address_building_number ?? '1234',
                        'city' => $saleBill->company->address_city ?? 'Al Majma\'ah',
                        'postal_code' => $saleBill->company->address_postal_code ?? '15365',
                        'district' => $saleBill->company->address_district ?? 'Al Majma\'ah District',
                    ],
                ],
                'buyer_info' => [
                    'name' => $saleBill->client?->name ?? $saleBill->outerClient?->name ?? 'عامر',
                    'country' => 'SA',
                ],
                'items' => $this->prepareItems($saleBill),
                'discounts' => $this->prepareDiscounts($saleBill),
                'additions' => $this->prepareAdditions($saleBill),
            ];

            DB::transaction(function () use ($saleBill, $bill, $companyOnboardingData) {
                $billData = $this->zatcaService->prepareBill($bill);
                $result = $this->zatcaService->sendBill($billData, $companyOnboardingData, $saleBill->zatca_hash ?? '');

                $saleBill->update([
                    'zatca_status' => $result['status'] === 'REPORTED' ? 'sent' : 'failed',
                    'zatca_hash' => $result['hash'] ?? null,
                    'uuid' => $bill['uuid'],
                    'zatca_date' => $result['status'] === 'REPORTED' ? now() : null,
                    'zatca_error' => $result['status'] === 'REPORTED' ? null : ($result['error_message'] ?? 'Unknown error'),
                ]);

                Log::info($result['status'] === 'REPORTED' ? 'SaleBill sent to ZATCA' : 'Failed to send to ZATCA', [
                    'saleBillId' => $saleBill->id,
                    'result' => $result,
                ]);
            });
        } catch (\Exception $e) {
            Log::error('ZATCA processing failed', [
                'saleBillId' => $saleBill->id,
                'error' => $e->getMessage(),
            ]);
            $saleBill->update(['zatca_status' => 'failed', 'zatca_error' => $e->getMessage()]);
        }
    }

    protected function prepareItems(SaleBill1 $saleBill)
    {
        return $saleBill->elements->map(function ($element) {
            return [
                'name' => $element->product?->product_name ?? 'Unknown Product',
                'unit' => $element->unit?->code ?? 'pce',
                'quantity' => $element->quantity ?? 1,
                'price' => $element->product_price ?? 0,
                'discount' => $element->discount_value ?? 0,
                'discount_reason' => $element->discount_type ? 'discount' : null,
                'discount_reason_code' => '95',
                'vat_cat' => $element->tax_type ?? ZatcaService::VAT_CATEGORY_STANDARD,
                'vat_rate' => 15,
            ];
        })->toArray();
    }

    protected function prepareDiscounts(SaleBill1 $saleBill)
    {
        $discounts = $saleBill->extras?->where('action', 'discount')->map(function ($extra) {
            return [
                'amount' => $extra->value ?? 0,
                'reason' => $extra->discount_note ?? 'General Discount',
                'vat_cat' => $extra->tax_type ?? ZatcaService::VAT_CATEGORY_STANDARD,
                'vat_rate' => 15,
            ];
        })->toArray() ?? [];

        if ($saleBill->total_discount > 0) {
            $discounts[] = [
                'amount' => $saleBill->total_discount,
                'reason' => 'General Discount',
                'vat_cat' => ZatcaService::VAT_CATEGORY_STANDARD,
                'vat_rate' => 15,
            ];
        }

        return $discounts;
    }

    protected function prepareAdditions(SaleBill1 $saleBill)
    {
        return $saleBill->extras?->where('action', 'extra')->map(function ($extra) {
            return [
                'amount' => $extra->value ?? 0,
                'reason' => $extra->reason ?? 'Additional Charge',
                'reason_code' => 'AA',
                'vat_cat' => $extra->tax_type ?? ZatcaService::VAT_CATEGORY_STANDARD,
                'vat_rate' => 15,
            ];
        })->toArray() ?? [];
    }
}
