<?php

namespace App\Services;

use Exception;
use DOMDocument;
use DateTime;
use Ramsey\Uuid\Uuid;
use SimpleXMLElement;
use GuzzleHttp\Client;
use App\Models\Company;
use App\Models\SaleBill1;
use App\Models\OuterClient;
use Salla\ZATCA\GenerateCSR;
use App\Models\SaleBillElement1;
use Salla\ZATCA\Models\CSRRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Exception\RequestException;
use Saleh7\Zatca\{
    CertificateBuilder,
    ZatcaAPI,
    InvoiceSigner,
    // Storage,
    Invoice,
    InvoiceType,
    TaxScheme,
    PartyTaxScheme,
    Address,
    LegalEntity,
    Delivery,
    Party,
    Price,
    ClassifiedTaxCategory,
    Item,
    InvoiceLine,
    TaxCategory,
    TaxSubTotal,
    TaxTotal,
    LegalMonetaryTotal,
    AdditionalDocumentReference,
    GeneratorInvoice,
    UnitCode
};

class ZatcaService1
{
    // File paths for certificate and private key
    protected const CERTIFICATE_PATH = 'app/zatca/csr.pem';
    protected const PRIVATE_KEY_PATH = 'app/zatca/private_key.pem';

    // ZATCA API URLs
    protected const ZATCA_ENDPOINTS = [
        'reporting' => 'https://gw-fatoora.zatca.gov.sa/e-invoicing/developer-portal/invoices/reporting/single',
        'clearance' => 'https://gw-fatoora.zatca.gov.sa/e-invoicing/developer-portal/invoices/clearance/single'
    ];

    /**
     * Check if CSR already exists.
     */
    public static function isCSRGenerated(): bool
    {
        return file_exists(storage_path(self::CERTIFICATE_PATH)) && file_exists(storage_path(self::PRIVATE_KEY_PATH));
    }

    /**
     * Generate CSR and private key.
     */
    public static function generateCSR()
    {
        $data = CSRRequest::make()
            ->setUID('302125574900003')
            ->setSerialNumber('POS', '2.0', '1010551269')
            ->setCommonName('مؤسسة روافع المجد لتأجير المعدات')
            ->setCountryName('SA')
            ->setOrganizationName('مؤسسة روافع المجد لتأجير المعدات')
            ->setBusinessCategory('Retail');

        $CSR = GenerateCSR::fromRequest($data)->initialize()->generate();

        file_put_contents(storage_path(self::PRIVATE_KEY_PATH), $CSR->getPrivateKey());
        file_put_contents(storage_path(self::CERTIFICATE_PATH), $CSR->getCsrContent());

        return [
            'csr' => file_get_contents(storage_path(self::CERTIFICATE_PATH)),
            'private_key' => file_get_contents(storage_path(self::PRIVATE_KEY_PATH)),
        ];
    }


    public static function convertInvoiceToXML($invoiceId): string
    {
        $invoice = SaleBill1::findOrFail($invoiceId);
        $invoiceElements = SaleBillElement1::where('sale_bill_id', $invoiceId)->get();
        logger('tax1');
        logger($invoice->total_tax);
        if ($invoiceElements->isEmpty()) {
            throw new Exception("Invoice elements not found.");
        }

        // Generate a UUID for the invoice
        $invoiceUUID = Uuid::uuid4()->toString();

        // Determine the tax type based on the stored value
        $taxType = $invoice->value_added_tax; // Assuming `tax_type` is stored in the invoice (0, 1, or 2)
        $taxRate = 0; // Default tax rate for exempt or not including tax
        $isTaxIncluded = false; // Default to tax not included

        switch ($taxType) {
            case 0: // Not including tax
                $taxRate = 0; // No tax
                $isTaxIncluded = false;
                break;
            case 1: // Exempt tax
                $taxRate = 0; // No tax
                $isTaxIncluded = false;
                break;
            case 2: // Including tax
                $taxRate = 15; // Assuming 15% VAT for Saudi Arabia
                $isTaxIncluded = true;
                break;
            default:
                throw new Exception("Invalid tax type.");
        }

        // --- Previous Invoice Hash (PIH) ---
        $previousInvoiceHash = '';
        if ($invoice->previous_invoice_id) {
            // Fetch the previous invoice
            $previousInvoice = SaleBill1::find($invoice->previous_invoice_id);

            if ($previousInvoice) {
                // Generate the XML for the previous invoice
                $previousInvoiceXml = self::convertInvoiceToXML($previousInvoice->id);

                // Calculate the SHA-256 hash of the previous invoice XML
                $previousInvoiceHash = hash('sha256', $previousInvoiceXml);

                // Encode the hash in Base64
                $previousInvoiceHash = base64_encode($previousInvoiceHash);
            }
        }

        // Build the invoice using Saleh7\Zatca package
        $invoiceType = (new InvoiceType())
            ->setInvoice('standard')
            ->setInvoiceType('invoice')
            ->setIsThirdParty(false)
            ->setIsNominal(false)
            ->setIsExportInvoice(false)
            ->setIsSummary(false)
            ->setIsSelfBilled(false);

        $taxScheme = (new TaxScheme())->setId("VAT");

        $partyTaxSchemeSupplier = (new PartyTaxScheme())
            ->setTaxScheme($taxScheme)
            ->setCompanyId($invoice->company->tax_number ?? '302125574900003');

        $partyTaxSchemeCustomer = (new PartyTaxScheme())
            ->setTaxScheme($taxScheme)
            ->setCompanyId(optional($invoice->outerClient)->tax_number ?? '302125574900003');

        $address = (new Address())
            ->setStreetName('Prince Sultan Street')
            ->setBuildingNumber("2322")
            ->setPlotIdentification("2223")
            ->setCitySubdivisionName('Riyadh')
            ->setCityName('Riyadh')
            ->setPostalZone('23333')
            ->setCountry('SA');

        $delivery = (new Delivery())->setActualDeliveryDate($invoice->date ?? now()->format('Y-m-d'));

        $legalEntitySupplier = (new LegalEntity())->setRegistrationName('مؤسسة روافع المجد لتأجير المعدات');
        $legalEntityCustomer = (new LegalEntity())->setRegistrationName(optional($invoice->outerClient)->name ?? 'Default Customer');

        $supplierCompany = (new Party())
            ->setPartyIdentification('302125574900003')
            ->setPartyIdentificationId("CRN")
            ->setLegalEntity($legalEntitySupplier)
            ->setPartyTaxScheme($partyTaxSchemeSupplier)
            ->setPostalAddress($address);

        $supplierCustomer = (new Party())
            ->setPartyIdentification(optional($invoice->outerClient)->tax_number ?? '123456789')
            ->setPartyIdentificationId("NAT")
            ->setLegalEntity($legalEntityCustomer)
            ->setPartyTaxScheme($partyTaxSchemeCustomer)
            ->setPostalAddress($address);

        // --- Additional Document References ---
        $additionalDocs = [];

        // Invoice Counter Value (ICV)
        $invoiceCounterValue = $invoice->company_counter;
        $additionalDocs[] = (new AdditionalDocumentReference())
            ->setId('ICV')
            ->setUUID($invoiceCounterValue);

        // Previous Invoice Hash (PIH)
        $additionalDocs[] = (new AdditionalDocumentReference())
            ->setId('PIH')
            ->setUUID($previousInvoiceHash);

        // QR Code
        $qrCodeData = [
            'SellerVAT' => '302125574900003', // Seller's VAT number
            'InvoiceTotal' => $invoice->final_total, // Invoice total including tax
            'InvoiceTax' => $invoice->total_tax, // Tax amount
            'InvoiceTimestamp' => $invoice->date . 'T' . $invoice->time . 'Z', // Invoice timestamp in ISO 8601 format
            'InvoiceUUID' => $invoiceUUID, // Use the generated UUID
        ];
        $qrCode = base64_encode(json_encode($qrCodeData));
        $additionalDocs[] = (new AdditionalDocumentReference())
            ->setId('QR')
            ->setUUID($qrCode);
        // --- Invoice Items & Pricing ---
        $invoiceLines = [];
        foreach ($invoiceElements as $element) {
            $classifiedTax = (new ClassifiedTaxCategory())->setPercent($taxRate)->setTaxScheme($taxScheme);
            $productItem = (new Item())->setName(optional($element->product)->name ?? 'Product Name')->setClassifiedTaxCategory($classifiedTax);
            $price = (new Price())->setUnitCode(UnitCode::UNIT)->setPriceAmount($element->product_price ?? 0);

            $invoiceLine = (new InvoiceLine())
                ->setUnitCode(optional($element->unit)->code ?? 'PCS')
                ->setId($element->id)
                ->setItem($productItem)
                ->setLineExtensionAmount($element->quantity_price ?? 0)
                ->setPrice($price)
                ->setInvoicedQuantity($element->quantity);

            $invoiceLines[] = $invoiceLine;
        }

        // --- Tax Totals ---
        $taxCategory = (new TaxCategory)
            ->setPercent($taxRate)
            ->setTaxScheme($taxScheme);
        $taxSubTotal = (new TaxSubTotal)
            ->setTaxableAmount($invoice->final_total ?? 0)
            ->setTaxAmount($invoice->total_tax ?? 0)
            ->setTaxCategory($taxCategory);
        $taxTotal = (new TaxTotal)
            ->addTaxSubTotal($taxSubTotal)
            ->setTaxAmount($invoice->total_tax ?? 0);

        // Ensure zero-rated VAT has a tax amount of 0
        // if ($taxType == 1) { // Exempt tax
        //     $taxTotal->setTaxAmount(0);
        // }
        logger('tax2');
        logger($invoice->total_tax);
        logger($taxType);
        // --- Legal Monetary Total ---
        $legalMonetaryTotal = (new LegalMonetaryTotal())
            ->setLineExtensionAmount($invoice->final_total ?? 0)
            ->setTaxExclusiveAmount($invoice->final_total ?? 0)
            ->setTaxInclusiveAmount($invoice->final_total + $invoice->total_tax ?? 0)
            ->setPrepaidAmount(0)
            ->setPayableAmount($invoice->final_total + $invoice->total_tax ?? 0)
            ->setAllowanceTotalAmount(0);

        // --- Build the Invoice ---
        $invoice = (new Invoice())
            ->setUUID($invoiceUUID) // Use the generated UUID
            ->setId($invoice->company_counter ?? 'INV-001') // Invoice ID
            ->setIssueDate(new DateTime($invoice->date ?? now()->format('Y-m-d'))) // Invoice issue date
            ->setIssueTime(new DateTime($invoice->time ?? now()->format('H:i:s'))) // Invoice issue time
            ->setInvoiceType($invoiceType) // Invoice type
            ->setInvoiceCurrencyCode('SAR') // Currency code
            ->setTaxCurrencyCode('SAR') // Tax currency code
            ->setDelivery($delivery) // Delivery information
            ->setAccountingSupplierParty($supplierCompany) // Supplier information
            ->setAccountingCustomerParty($supplierCustomer) // Customer information
            ->setAdditionalDocumentReferences($additionalDocs) // Additional document references
            ->setTaxTotal($taxTotal) // Tax total
            ->setLegalMonetaryTotal($legalMonetaryTotal) // Legal monetary total
            ->setInvoiceLines($invoiceLines); // Invoice lines

        // Generate the XML
        $generatorXml = GeneratorInvoice::invoice($invoice);
        $xml = $generatorXml->getXML();

        // Log the XML for debugging
        Log::info('Generated Invoice XML:', ['xml' => $xml]);

        return $xml;
    }
    /**
     * Validate XML structure.
     */
    public static function validateXML($xml)
    {
        // Create a new DOMDocument instance
        $dom = new \DOMDocument();

        // Suppress warnings for invalid XML
        libxml_use_internal_errors(true);

        // Attempt to load the XML
        $loaded = $dom->loadXML($xml);

        // Check if the XML was loaded successfully
        if (!$loaded) {
            // Log XML errors
            $errors = libxml_get_errors();
            foreach ($errors as $error) {
                Log::error('XML Error: ' . $error->message);
            }
            libxml_clear_errors(); // Clear errors for future operations
            return false;
        }

        // If the XML is well-formed, return true
        return true;
    }

    /**
     * Sign invoice using the private key.
     */
    public static function signInvoice(string $xml): string
    {
        // Load the private key
        $privateKey = file_get_contents(storage_path(self::PRIVATE_KEY_PATH));

        // Create a signature
        openssl_sign($xml, $signature, $privateKey, OPENSSL_ALGO_SHA256);

        // Encode the signature in base64
        $base64Signature = base64_encode($signature);

        // Append the signature to the XML (Ensure correct placement)
        $dom = new DOMDocument();
        $dom->loadXML($xml);

        // Create Signature element
        $signatureElement = $dom->createElement('Signature', $base64Signature);

        // Find the correct position to insert the Signature element
        $invoiceLineElement = $dom->getElementsByTagName('InvoiceLine')->item(0);
        if ($invoiceLineElement) {
            $invoiceLineElement->parentNode->insertBefore($signatureElement, $invoiceLineElement);
        } else {
            $dom->documentElement->appendChild($signatureElement);
        }

        return $dom->saveXML();
    }

    /**
     * Generate invoice hash.
     */
    public static function generateInvoiceHash(string $xml): string
    {
        // Compute SHA-256 hash
        $hash = hash('sha256', $xml, true);

        // Encode the hash in Base64
        return base64_encode($hash);
    }

    /**
     * Generate UUID.
     */
    public static function generateUUID(): string
    {
        return Uuid::uuid4()->toString();
    }

    /**
     * Send invoice to ZATCA.
     */
    public function sendInvoiceToZatca($signedInvoiceXml, $invoiceType = 'reporting')
    {
        try {
            $apiUrl = self::ZATCA_ENDPOINTS[$invoiceType] ?? self::ZATCA_ENDPOINTS['reporting'];

            $base64Invoice = base64_encode($signedInvoiceXml);

            // Generate hash and UUID
            $invoiceHash = self::generateInvoiceHash($signedInvoiceXml);
            $uuid = self::generateUUID();

            $payload = [
                "invoice" => $base64Invoice,
                "invoiceHash" => $invoiceHash,
                "uuid" => $uuid,
            ];

            // Log::info('Payload sent to ZATCA:', ['payload' => $payload]);

            $headers = [
                'Content-Type'    => 'application/json',
                'Accept'          => 'application/json',
                'Accept-Language' => 'ar',
                'accept-version'  => 'v2',
                'Authorization'   => 'Basic ' . base64_encode(
                    'TUlJRDNqQ0NBNFNnQXdJQkFnSVRFUUFBT0FQRjkwQWpzL3hjWHdBQkFBQTRBekFLQmdncWhrak9QUVFEQWpCaU1SVXdFd1lLQ1pJbWlaUHlMR1FCR1JZRmJHOWpZV3d4RXpBUkJnb0praWFKay9Jc1pBRVpGZ05uYjNZeEZ6QVZCZ29Ka2lhSmsvSXNaQUVaRmdkbGVIUm5ZWHAwTVJzd0dRWURWUVFERXhKUVVscEZTVTVXVDBsRFJWTkRRVFF0UTBFd0hoY05NalF3TVRFeE1Ea3hPVE13V2hjTk1qa3dNVEE1TURreE9UTXdXakIxTVFzd0NRWURWUVFHRXdKVFFURW1NQ1FHQTFVRUNoTWRUV0Y0YVcxMWJTQlRjR1ZsWkNCVVpXTm9JRk4xY0hCc2VTQk1WRVF4RmpBVUJnTlZCQXNURFZKcGVXRmthQ0JDY21GdVkyZ3hKakFrQmdOVkJBTVRIVlJUVkMwNE9EWTBNekV4TkRVdE16azVPVGs1T1RrNU9UQXdNREF6TUZZd0VBWUhLb1pJemowQ0FRWUZLNEVFQUFvRFFnQUVvV0NLYTBTYTlGSUVyVE92MHVBa0MxVklLWHhVOW5QcHgydmxmNHloTWVqeThjMDJYSmJsRHE3dFB5ZG84bXEwYWhPTW1Obzhnd25pN1h0MUtUOVVlS09DQWdjd2dnSURNSUd0QmdOVkhSRUVnYVV3Z2FLa2daOHdnWnd4T3pBNUJnTlZCQVFNTWpFdFZGTlVmREl0VkZOVWZETXRaV1F5TW1ZeFpEZ3RaVFpoTWkweE1URTRMVGxpTlRndFpEbGhPR1l4TVdVME5EVm1NUjh3SFFZS0NaSW1pWlB5TEdRQkFRd1BNems1T1RrNU9UazVPVEF3TURBek1RMHdDd1lEVlFRTURBUXhNVEF3TVJFd0R3WURWUVFhREFoU1VsSkVNamt5T1RFYU1CZ0dBMVVFRHd3UlUzVndjR3g1SUdGamRHbDJhWFJwWlhNd0hRWURWUjBPQkJZRUZFWCtZdm1tdG5Zb0RmOUJHYktvN29jVEtZSzFNQjhHQTFVZEl3UVlNQmFBRkp2S3FxTHRtcXdza0lGelZ2cFAyUHhUKzlObk1Ic0dDQ3NHQVFVRkJ3RUJCRzh3YlRCckJnZ3JCZ0VGQlFjd0FvWmZhSFIwY0RvdkwyRnBZVFF1ZW1GMFkyRXVaMjkyTG5OaEwwTmxjblJGYm5KdmJHd3ZVRkphUlVsdWRtOXBZMlZUUTBFMExtVjRkR2RoZW5RdVoyOTJMbXh2WTJGc1gxQlNXa1ZKVGxaUFNVTkZVME5CTkMxRFFTZ3hLUzVqY25Rd0RnWURWUjBQQVFIL0JBUURBZ2VBTUR3R0NTc0dBUVFCZ2pjVkJ3UXZNQzBHSlNzR0FRUUJnamNWQ0lHR3FCMkUwUHNTaHUyZEpJZk8reG5Ud0ZWbWgvcWxaWVhaaEQ0Q0FXUUNBUkl3SFFZRFZSMGxCQll3RkFZSUt3WUJCUVVIQXdNR0NDc0dBUVVGQndNQ01DY0dDU3NHQVFRQmdqY1ZDZ1FhTUJnd0NnWUlLd1lCQlFVSEF3TXdDZ1lJS3dZQkJRVUhBd0l3Q2dZSUtvWkl6ajBFQXdJRFNBQXdSUUloQUxFL2ljaG1uV1hDVUtVYmNhM3ljaThvcXdhTHZGZEhWalFydmVJOXVxQWJBaUE5aEM0TThqZ01CQURQU3ptZDJ1aVBKQTZnS1IzTEUwM1U3NWVxYkMvclhBPT0=:CkYsEXfV8c1gFHAtFWoZv73pGMvh/Qyo4LzKM2h/8Hg='
                )
            ];
            // Log::info('Headers sent to ZATCA:', ['headers' => $headers]);

            $response = Http::withHeaders($headers)->post($apiUrl, $payload);

            // Log the raw response and status code
            // Log::info('ZATCA Raw Response:', [
            //     'status' => $response->status(),
            //     'body' => $response->body()
            // ]);

            $responseData = $response->json();
            // Log::info('ZATCA Response:', ['response' => $responseData ?? 'No response data']);

            if ($response->failed()) {
                Log::error('ZATCA API Validation Error:', [
                    'status'   => $response->status(),
                    'response' => $responseData ?? 'No response data'
                ]);
                throw new \Exception('ZATCA API error: ' . json_encode($responseData ?? 'No response data'));
            }

            return [
                'success' => true,
                'status'  => $response->status(),
                'body'    => $responseData
            ];
        } catch (\Exception $e) {
            Log::error('Error sending invoice to ZATCA', ['error' => $e->getMessage()]);
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
}
