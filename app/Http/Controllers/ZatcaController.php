<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\SaleBill1;
use App\Models\ZatcaCompany;
use Illuminate\Http\Request;
use App\Services\ZatcaService;

class ZatcaController extends Controller
{
    protected $zatcaService;

    public function __construct(ZatcaService $zatcaService)
    {
        $this->zatcaService = $zatcaService;
    }

    public function onboard(Request $request, Company $company)
    {
        $data = [
            'otp' => $request->otp,
            'vat_id' => $request->vat_id,
            'organization' => $request->organization,
            'business' => $request->business,
            'country' => $request->country,
            'branch' => $request->branch,
            'address' => $request->address,
            'unit_name' => $request->unit_name,
            'app_name' => $request->app_name,
            'app_version' => $request->app_version,
            'app_copy_sn' => $request->app_copy_sn,
            'is_production' => $request->is_production,
        ];

        $response = $this->zatcaService->onboard($data);
        if (isset($response['onboarding_data']) && $response['onboarding_data']) {
            $company->update([
                'onboarding_data' => $response['onboarding_data'],
            ]);

            return redirect()->back()->with('success', 'Company onboarded successfully with ZATCA');
        }

        return redirect()->back()->with('error', $response['error_message'] ?? 'Failed to onboard with ZATCA');
    }

    // public function sendInvoice(Request $request, $saleBillId)
    // {
    //     logger($saleBillId);

    //     $saleBill = SaleBill1::findOrFail($saleBillId); // Use SaleBill instead of Invoice
    //     $company = $saleBill->company; // Adjust based on your relationship
    //     $zatcaCompany = $company->zatca;

    //     if (!$zatcaCompany || !$zatcaCompany->onboarding_data) {
    //         return redirect()->back()->with('error', 'Company not onboarded with ZATCA.');
    //     }

    //     $bill = [
    //         'bill_type' => ZatcaService::BILL_TYPE_INVOICE,
    //         'reference_number' => $saleBill->reference_number,
    //         'uuid' => $saleBill->uuid ?? (string) \Illuminate\Support\Str::uuid(),
    //         'currency' => 'SAR',
    //         'is_simplified' => true,
    //         'seller_info' => [
    //             'name' => $company->name,
    //             'id' => $company->crn ?? '151001111111113',
    //             'id_type' => 'CRN',
    //             'country' => 'SA',
    //             'city_name' => 'الرياض | Riyadh',
    //             'postal_zone' => '23333',
    //             'street' => 'الامير سلطان',
    //             'plot_identification' => '2223',
    //             'building_number' => '2322',
    //         ],
    //         'buyer_info' => [
    //             'name' => $saleBill->customer_name, // Adjust based on your column name
    //             'country' => 'SA',
    //         ],
    //         'items' => $saleBill->elements->map(function ($item) { // Adjust based on your relationship
    //             return [
    //                 'name' => $item->name,
    //                 'unit' => 'pce',
    //                 'quantity' => $item->quantity,
    //                 'price' => $item->price,
    //                 'discount' => $item->discount ?? 0,
    //                 'discount_reason' => 'discount',
    //                 'discount_reason_code' => '95',
    //                 'vat_cat' => ZatcaService::VAT_CATEGORY_STANDARD,
    //                 'vat_rate' => 15,
    //             ];
    //         })->toArray(),
    //     ];

    //     logger($bill);
    //     $billData = $this->zatcaService->prepareBill($bill);
    //     logger('1');
    //     logger($billData);
    //     $result = $this->zatcaService->sendBill(
    //         $billData,
    //         $zatcaCompany->onboarding_data,
    //         $zatcaCompany->last_hash ?? '',
    //         $zatcaCompany->sequence
    //     );
    //     logger('2');
    //     logger($result['status']);
    //     if ($result['status'] === 'success') {
    //         $zatcaCompany->update([
    //             'last_hash' => $result['hash'],
    //             'sequence' => $zatcaCompany->sequence + 1,
    //         ]);
    //         $saleBill->update([
    //             'zatca_status' => 'sent',
    //             'zatca_hash' => $result['hash'],
    //             'uuid' => $bill['uuid'], // Ensure UUID is saved if newly generated
    //         ]);
    //         return redirect()->back()->with('success', 'Invoice sent to ZATCA!');
    //     }

    //     return redirect()->back()->with('error', $result['error_message']);
    // }
    public function sendInvoice(Request $request, $saleBillId)
    {
        logger('id'.$saleBillId);
        $saleBill = SaleBill1::findOrFail($saleBillId);
        $company = $saleBill->company;

        // Dynamically build the bill array from the SaleBill and its elements
        $bill = [
            'bill_type' => ZatcaService::BILL_TYPE_INVOICE,
            'reference_number' => $saleBill->sale_bill_number,
            'uuid' => $saleBill->uuid ?? \Illuminate\Support\Str::uuid(),
            'currency' => 'SAR', // You might want to make this configurable
            'is_simplified' => true,
            'seller_info' => [
                'name' => $company->company_name ?? 'الزهور',
                'id' => $company->crn ?? '151001111111113', // Assuming company has a CRN field
                'id_type' => 'CRN',
                'country' => 'SA',
                'address' => $company->company_address,
                // Add more fields from company if available
            ],
            'buyer_info' => [
                'name' => $saleBill->client?->name ?? $saleBill->outerClient?->name ?? 'عامر',
                'country' => 'SA',
                // Add more buyer info if available in client/outerClient
            ],
            'items' => $this->prepareItems($saleBill),
            'discounts' => $this->prepareDiscounts($saleBill),
            'additions' => $this->prepareAdditions($saleBill),
        ];
        $companyOnboardingData = $company->onboarding_data;
        if (empty($companyOnboardingData)) {
            throw new \Exception("Onboarding data is empty for company ID: {$company->id}");
        }

        // Clean and validate base64 data
        // $companyOnboardingData = base64_decode($companyOnboardingData, true);
        if (base64_decode($companyOnboardingData, true) === false) {
            logger("Invalid base64 onboarding data", ['data' => substr($companyOnboardingData, 0, 100) . '...']);
            throw new \Exception("Invalid onboarding data format. Please verify the stored data.");
        }
        logger("Onboarding data length: " . strlen($companyOnboardingData));
        // Get company onboarding data and handle ZATCA-specific fields
        // $companyOnboardingData = $companyOnboardingData;
        $lastHash = $saleBill->zatca_hash ?? ''; // Use previous hash if exists
        $sequence = $saleBill->company_counter ?? 1; // Use company counter or similar field

        logger($bill);
        $billData = $this->zatcaService->prepareBill($bill);
        logger('1');
        logger($billData);

        $result = $this->zatcaService->sendBill(
            $billData,
            $companyOnboardingData,
            $lastHash
        );
        logger($result);

        if ($result['status'] === 'REPORTED') {
            $saleBill->update([
                'zatca_status' => 'sent',
                'zatca_hash' => $result['hash'],
                'uuid' => $bill['uuid'],
            ]);
            return redirect()->back()->with('success', 'تم الارسال الى زاتكا!  Hash: ' . $result['hash']);
        }

        return redirect()->back()->with('error', $result['error_message']);
    }

    private function prepareItems($saleBill)
    {
        return $saleBill->elements->map(function ($element) {
            return [
                'name' => $element->product?->product_name ?? 'Unknown Product',
                'unit' => $element->unit?->code ?? 'pce', // Assuming Unit model has a code field
                'quantity' => $element->quantity,
                'price' => $element->product_price,
                'discount' => $element->discount_value,
                'discount_reason' => $element->discount_type ? 'discount' : null,
                'discount_reason_code' => '95', // You might want to make this dynamic
                'vat_cat' => $element->tax_type ?? ZatcaService::VAT_CATEGORY_STANDARD,
                // 'vat_rate' => $element->company->tax_value_added ?? 15,
                'vat_rate' => 15,
            ];
        })->toArray();
    }

    private function prepareDiscounts($saleBill)
    {
        // Assuming discounts are stored in extras or similar relationship
        if ($saleBill->extras) {
            return $saleBill->extras->where('type', 'discount')->map(function ($extra) {
                return [
                    'amount' => $extra->amount,
                    'reason' => $extra->reason ?? 'mgkj',
                    'vat_cat' => $extra->tax_type ?? ZatcaService::VAT_CATEGORY_STANDARD,
                    'vat_rate' => 15, // Calculate or get from somewhere
                ];
            })->toArray();
        }

        // If total_discount exists and no extras, use it
        if ($saleBill->total_discount > 0) {
            return [[
                'amount' => $saleBill->total_discount,
                'reason' => 'mgkj', // Default reason, make configurable
                'vat_cat' => ZatcaService::VAT_CATEGORY_STANDARD,
                'vat_rate' => 15,
            ]];
        }

        return [];
    }

    private function prepareAdditions($saleBill)
    {
        // Assuming additions are stored in extras
        if ($saleBill->extras) {
            return $saleBill->extras->where('type', 'addition')->map(function ($extra) {
                return [
                    'amount' => $extra->amount,
                    'reason' => $extra->reason ?? 'jnsdkjk',
                    'reason_code' => 'AA', // Make configurable
                    'vat_cat' => $extra->tax_type ?? ZatcaService::VAT_CATEGORY_STANDARD,
                    'vat_rate' => 15,
                ];
            })->toArray();
        }
        return [];
    }
    // public function sendInvoice(Request $request, $saleBillId)
    // {
    //     logger($saleBillId);

    //     $saleBill = SaleBill1::findOrFail($saleBillId); // Keep this for updating the record later
    //     $company = $saleBill->company;
    //     dd($company->tax_number);
    //     // Fixed data for testing (from your original PHP code)
    //     $bill = [
    //         'bill_type' => ZatcaService::BILL_TYPE_INVOICE,
    //         'reference_number' => $saleBill->company_counter,
    //         'uuid' => $saleBill->uuid,
    //         'currency' => 'SAR',
    //         'is_simplified' => true,
    //         'seller_info' => [
    //             'name' => $company->company_name,
    //             'id' => $company->tax_number,
    //             'id_type' => 'CRN',
    //             'country' => 'SA',
    //             'city_name' => $company->tax_number,
    //             'city_subdivision_name' => $company->tax_number,
    //             'postal_zone' => '23333',
    //             'street' => 'الامير سلطان',
    //             'plot_identification' => '2223',
    //             'building_number' => '2322',
    //         ],
    //         'buyer_info' => [
    //             'name' => 'عامر',
    //             'country' => 'SA',
    //         ],
    //         'items' => [
    //             [
    //                 'name' => 'pen',
    //                 'unit' => 'pce',
    //                 'quantity' => 2,
    //                 'price' => 3,
    //                 'discount' => 1.5,
    //                 'discount_reason' => 'discount',
    //                 'discount_reason_code' => '95',
    //                 'vat_cat' => ZatcaService::VAT_CATEGORY_STANDARD,
    //                 'vat_rate' => 15,
    //             ],
    //         ],
    //         'discounts' => [
    //             [
    //                 'amount' => 1,
    //                 'reason' => 'mgkj',
    //                 'vat_cat' => ZatcaService::VAT_CATEGORY_STANDARD,
    //                 'vat_rate' => 15,
    //             ],
    //         ],
    //         'additions' => [
    //             [
    //                 'amount' => 1,
    //                 'reason' => 'jnsdkjk',
    //                 'reason_code' => 'AA',
    //                 'vat_cat' => ZatcaService::VAT_CATEGORY_STANDARD,
    //                 'vat_rate' => 15,
    //             ],
    //         ],
    //     ];

    //     // Fixed onboarding data, last_hash, and sequence
    //     $companyOnboardingData = "";
    //     $fixedLastHash = ''; // Initial empty hash for testing
    //     $fixedSequence = 1;  // Starting sequence for testing

    //     logger($bill);
    //     $billData = $this->zatcaService->prepareBill($bill);
    //     logger('1');
    //     logger($billData);

    //     $result = $this->zatcaService->sendBill(
    //         $billData,
    //         $companyOnboardingData, // Use fixed onboarding data
    //         $fixedLastHash,       // Use fixed last_hash
    //         $fixedSequence        // Use fixed sequence
    //     );
    //     logger($result);

    //     if ($result['status'] === 'success') {
    //         // For testing, we won't update ZatcaCompany since we're bypassing onboarding
    //         // Just update the SaleBill record
    //         $saleBill->update([
    //             'zatca_status' => 'sent',
    //             'zatca_hash' => $result['hash'],
    //             'uuid' => $bill['uuid'],
    //         ]);
    //         return redirect()->back()->with('success', 'Invoice sent to ZATCA! Hash: ' . $result['hash']);
    //     }

    //     return redirect()->back()->with('error', $result['error_message']);
    // }
}
