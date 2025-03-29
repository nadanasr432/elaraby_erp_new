<?php

namespace App\Services;

use DateTime;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class ZatcaService
{
    protected $client;

    public const VAT_CATEGORY_STANDARD = 'standard';
    public const VAT_CATEGORY_ZERO = 'zero';
    public const VAT_CATEGORY_EXEMPT = 'exempt';
    public const VAT_CATEGORY_OUT_OF_SCOPE = 'out';

    public const BILL_TYPE_INVOICE = 'invoice';
    public const BILL_TYPE_CREDIT_NOTE = 'credit';
    public const BILL_TYPE_DEBIT_NOTE = 'debit';

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'http://193.46.198.176:8052',
            'timeout' => 30.0,
        ]);
    }

    public function sendBill($billData, $onboardingData, $lastHash)
    {
        try {
            $payload = array_merge($billData, [
                'onboarding_data' => $onboardingData,
                'last_hash' => $lastHash,
                // 'sequence' => $sequence,
            ]);

            logger('Sending payload to ZATCA: ' . json_encode($payload, JSON_UNESCAPED_UNICODE));

            $response = $this->client->post('/send', [
                'json' => $payload,
                'headers' => [
                    'Content-Type' => 'application/json; charset=utf-8',
                    'Accept' => 'application/json',
                ],
            ]);

            $body = $response->getBody()->getContents();
            logger('Response from ZATCA: ' . $body);

            $result = json_decode($body, true);

            if (isset($result['status']) && $result['status'] === 'success') {
                return [
                    'status' => 'success',
                    'hash' => $result['hash'] ?? '',
                    'invoice' => $result['invoice'] ?? '',
                    'qr' => $result['qr'] ?? '',
                ];
            }

            return [
                'status' => $result['status'] ?? 'error',
                'error_message' => $result['errorMessage'] ?? 'Done',
                'invoice' => '',
                'qr' => $result['qr'] ?? 'error',
                'hash' => $result['hash'] ?? 'error',
                // 'sequence' => $result['sequence'] ?? '',

            ];
        } catch (RequestException $e) {
            logger('Guzzle exception: ' . $e->getMessage());
            if ($e->hasResponse()) {
                logger('Response body: ' . $e->getResponse()->getBody()->getContents());
            }
            return [
                'status' => 'exp',
                'error_message' => $e->getMessage(),
                'invoice' => '',
                'hash' => '',
                'qr' => '',
            ];
        } catch (\Exception $e) {
            logger('General exception: ' . $e->getMessage());
            return [
                'status' => 'exp',
                'error_message' => $e->getMessage(),
                'invoice' => '',
                'hash' => '',
                'qr' => '',
            ];
        }
    }

    public function prepareBill($bill)
    {
        return [
            'refnum' => $bill['reference_number'],
            'uuid' => $bill['uuid'],
            'datetime' => (new DateTime())->format('Y-m-d H:i:s'),
            'currency' => $bill['currency'],
            'bill_type' => $bill['bill_type'],
            'is_simplified' => $bill['is_simplified'],
            'seller_name' => $bill['seller_info']['name'],
            'seller_id' => $bill['seller_info']['id'],
            'seller_id_type' => $bill['seller_info']['id_type'],
            'seller_country' => $bill['seller_info']['country'],
            // 'seller_city' => $bill['seller_info']['city_name'],
            // 'seller_postal' => $bill['seller_info']['postal_zone'],
            // 'seller_street' => $bill['seller_info']['street'],
            // 'seller_plot_id' => $bill['seller_info']['plot_identification'],
            // 'seller_building' => $bill['seller_info']['building_number'],
            'buyer_name' => $bill['buyer_info']['name'],
            'buyer_country' => $bill['buyer_info']['country'],
            'items' => $bill['items'],
            'discounts' => $bill['discounts'] ?? [],
            'additions' => $bill['additions'] ?? [],
        ];
    }

    public function onboard(array $data)
    {
        try {
            // تنسيق البيانات بناءً على الكود الأصلي
            $payload = [
                'otp' => $data['otp'],
                'vat_id' => $data['vat_id'],
                'organization' => $data['organization'],
                'business' => $data['business'],
                'country' => $data['country'],
                'branch' => $data['branch'],
                'address' => $data['address'],
                'unit_name' => $data['unit_name'],
                'app_name' => $data['app_name'],
                'app_version' => $data['app_version'],
                'app_copy_sn' => $data['app_copy_sn'],
                'is_production' => $data['is_production'],
            ];

            logger('Onboarding payload: ' . json_encode($payload, JSON_UNESCAPED_UNICODE));

            $response = $this->client->post('/onboard', [
                'json' => $payload,
                'headers' => [
                    'Content-Type' => 'application/json; charset=utf-8',
                    'Accept' => 'application/json',
                ],
            ]);

            $body = $response->getBody()->getContents();
            logger('Onboarding response: ' . $body);

            $result = json_decode($body, true);

            return [
                'result' => $result['result'] ?? '',
                'error_message' => $result['error_message'] ?? '',
                'onboarding_data' => $result['onboarding_data'] ?? '',
            ];
        } catch (\Throwable $e) {
            logger('Exception in onboard: ' . $e->getMessage());
            if ($e instanceof RequestException && $e->hasResponse()) {
                logger('Response body: ' . $e->getResponse()->getBody()->getContents());
            }
            return [
                'result' => 'error',
                'error_message' => $e->getMessage(),
                'onboarding_data' => '',
            ];
        }
    }
}
