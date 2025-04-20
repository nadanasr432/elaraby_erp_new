<?php
$ZatcaServer = "193.46.198.176";

class ZVatCategory
{
    const standard = "standard";
    const zero = "zero";
    const excempt = "excempt";
    const outOfScope = "out";
}

class ZValidationResults
{
    public $errorMessages;
    public $infoMessages;
    public $status;
    public $warningMessages;
}

class ZSellerBuyerInfo
{
    public $street;
    public $buildingNumber;
    public $plotIdentification;
    public $citySubdivisionName;
    public $cityName;
    public $postalZone;
    public $country;
    public $name;
    public $vatID;
    public $id;
    public $idType;
}

class ZResult
{
    public $status;
    public $errorMessage;
    public $invoice;
    public $hash;
    public $qr;
    public $validationResults;

    public static function fromJson($jsonObject)
    {
        $zResult = new ZResult();
        $zResult->status = isset($jsonObject["status"]) ? $jsonObject["status"] : "";
        $zResult->errorMessage = isset($jsonObject["errorMessage"]) ? $jsonObject["errorMessage"] : "";
        $zResult->invoice = isset($jsonObject["invoice"]) ? $jsonObject["invoice"] : "";
        $zResult->hash = isset($jsonObject["hash"]) ? $jsonObject["hash"] : "";
        $zResult->qr = isset($jsonObject["qr"]) ? $jsonObject["qr"] : "";

        // Load validationResults
        if (isset($jsonObject["validationResults"]) && is_array($jsonObject["validationResults"])) {
            $vrJson = $jsonObject["validationResults"];
            $zResult->validationResults = new ZValidationResults();
            $zResult->validationResults->status = isset($vrJson["status"]) ? $vrJson["status"] : "";

            // Load errorMessages
            if (isset($vrJson["errorMessages"]) && is_array($vrJson["errorMessages"])) {
                $zResult->validationResults->errorMessages = array();
                for ($i = 0; $i < count($vrJson["errorMessages"]); $i++) {
                    $messageJson = $vrJson["errorMessages"][$i];
                    if (is_array($messageJson)) {
                        $message = new ZMessage();
                        $message->category = isset($messageJson["category"]) ? $messageJson["category"] : "";
                        $message->code = isset($messageJson["code"]) ? $messageJson["code"] : "";
                        $message->message = isset($messageJson["message"]) ? $messageJson["message"] : "";
                        $message->status = isset($messageJson["status"]) ? $messageJson["status"] : "";
                        $message->type = isset($messageJson["type"]) ? $messageJson["type"] : "";
                        $zResult->validationResults->errorMessages[] = $message;
                    }
                }
            }

            // Load infoMessages
            if (isset($vrJson["infoMessages"]) && is_array($vrJson["infoMessages"])) {
                $zResult->validationResults->infoMessages = array();
                for ($i = 0; $i < count($vrJson["infoMessages"]); $i++) {
                    $messageJson = $vrJson["infoMessages"][$i];
                    if (is_array($messageJson)) {
                        $message = new ZMessage();
                        $message->category = isset($messageJson["category"]) ? $messageJson["category"] : "";
                        $message->code = isset($messageJson["code"]) ? $messageJson["code"] : "";
                        $message->message = isset($messageJson["message"]) ? $messageJson["message"] : "";
                        $message->status = isset($messageJson["status"]) ? $messageJson["status"] : "";
                        $message->type = isset($messageJson["type"]) ? $messageJson["type"] : "";
                        $zResult->validationResults->infoMessages[] = $message;
                    }
                }
            }

            // Load warningMessages
            if (isset($vrJson["warningMessages"]) && is_array($vrJson["warningMessages"])) {
                $zResult->validationResults->warningMessages = array();
                for ($i = 0; $i < count($vrJson["warningMessages"]); $i++) {
                    $messageJson = $vrJson["warningMessages"][$i];
                    if (is_array($messageJson)) {
                        $message = new ZMessage();
                        $message->category = isset($messageJson["category"]) ? $messageJson["category"] : "";
                        $message->code = isset($messageJson["code"]) ? $messageJson["code"] : "";
                        $message->message = isset($messageJson["message"]) ? $messageJson["message"] : "";
                        $message->status = isset($messageJson["status"]) ? $messageJson["status"] : "";
                        $message->type = isset($messageJson["type"]) ? $messageJson["type"] : "";
                        $zResult->validationResults->warningMessages[] = $message;
                    }
                }
            }
        }
        return $zResult;
    }
}

class ZOnboardingResult
{
    public $result;
    public $errorMessage;
    public $onboardingData;
}

class ZMessage
{
    public $category = '';
    public $code = '';
    public $message = '';
    public $status = '';
    public $type = '';
}

class ZBillType
{
    const invoice = "invoice";
    const creditNote = "credit";
    const debitNote = "debit";
}

class ZBillItem
{
    public $name;
    public $unit;
    public $quantity;
    public $price;
    public $discount;
    public $discountReason;
    public $discountReasonCode;
    public $vatCategory;
    public $vatRate;

    public function __construct(
        $name,
        $unit,
        $quantity,
        $price,
        $discount,
        $discountReason,
        $discountReasonCode,
        $vatCategory,
        $vatRate
    ) {
        $this->name = $name;
        $this->unit = $unit;
        $this->quantity = $quantity;
        $this->price = $price;
        $this->discount = $discount;
        $this->discountReason = $discountReason;
        $this->discountReasonCode = $discountReasonCode;
        $this->vatCategory = $vatCategory;
        $this->vatRate = $vatRate;
    }
}

class ZBillDiscount
{
    public $amount;
    public $reason;
    public $vatCategory;
    public $vatRate;

    public function __construct($amount, $reason, $vatCategory, $vatRate)
    {
        $this->amount = $amount;
        $this->reason = $reason;
        $this->vatCategory = $vatCategory;
        $this->vatRate = $vatRate;
    }
}

class ZBillAddition
{
    public $amount;
    public $reason;
    public $reasonCode;
    public $vatCategory;
    public $vatRate;

    public function __construct($amount, $reason, $reasonCode, $vatCategory, $vatRate)
    {
        $this->amount = $amount;
        $this->reason = $reason;
        $this->reasonCode = $reasonCode;
        $this->vatCategory = $vatCategory;
        $this->vatRate = $vatRate;
    }
}

class ZBill
{
    private static $dateFormat = "Y-m-d h:i:s";
    public $items = array();
    public $additions = array();
    public $discounts = array();
    public $sellerInfo;
    public $buyerInfo;
    public $referenceNumber;
    public $uuid;
    public $time;
    public $currency;
    public $billType;
    public $isSimplified;
    public $creditDebitReason;
    public $paymentMeansCode;
    public $creditDebitOrgBillReferenceNum;
    public $creditDebitOrgBillDate;
    public $zeroVatReason;
    public $zeroVatReasonCode;
    public $exemptVatReason;
    public $exemptVatReasonCode;
    public $outOfScopeVatReason;
    public $outOfScopeVatReasonCode;
    public $currencyToSAR;

    public function __construct()
    {
        $this->items = array();
        $this->additions = array();
        $this->discounts = array();
        $this->sellerInfo = new ZSellerBuyerInfo();
        $this->buyerInfo = new ZSellerBuyerInfo();
    }

    public function toJSONObject()
    {
        $jsonObject = array();
        $jsonObject["refnum"] = $this->referenceNumber;
        $jsonObject["uuid"] = $this->uuid;
        $jsonObject["datetime"] = ($this->time != null) ? date(self::$dateFormat, $this->time->getTimestamp()) : "";
        $jsonObject["currency"] = $this->currency;
        $jsonObject["bill_type"] = ZBillType::creditNote;
        $jsonObject["is_simplified"] = $this->isSimplified;
        $jsonObject["credit_debit_reason"] = $this->creditDebitReason;
        $jsonObject["payment_means_code"] = $this->paymentMeansCode;
        $jsonObject["credit_debit_org_num"] = $this->creditDebitOrgBillReferenceNum;
        $jsonObject["credit_debit_org_date"] = ($this->creditDebitOrgBillDate != null) ? date(self::$dateFormat, $this->creditDebitOrgBillDate->getTimestamp()) : "";
        $jsonObject["zero_vat_reason"] = $this->zeroVatReason;
        $jsonObject["zero_vat_reason_code"] = $this->zeroVatReasonCode;
        $jsonObject["exempt_vat_reason"] = $this->exemptVatReason;
        $jsonObject["exempt_vat_reason_code"] = $this->exemptVatReasonCode;
        $jsonObject["out_vat_reason"] = $this->outOfScopeVatReason;
        $jsonObject["out_vat_reason_code"] = $this->outOfScopeVatReasonCode;
        $jsonObject["currency_to_sar"] = $this->currencyToSAR;

        // Seller Info
        if ($this->sellerInfo != null) {
            $jsonObject["seller_street"] = $this->sellerInfo->street;
            $jsonObject["seller_building"] = $this->sellerInfo->buildingNumber;
            $jsonObject["seller_plot_id"] = $this->sellerInfo->plotIdentification;
            $jsonObject["seller_city_sub"] = $this->sellerInfo->citySubdivisionName;
            $jsonObject["seller_city"] = $this->sellerInfo->cityName;
            $jsonObject["seller_postal"] = $this->sellerInfo->postalZone;
            $jsonObject["seller_country"] = $this->sellerInfo->country;
            $jsonObject["seller_name"] = $this->sellerInfo->name;
            $jsonObject["seller_id"] = $this->sellerInfo->id;
            $jsonObject["seller_id_type"] = $this->sellerInfo->idType;
        }

        // Buyer Info
        if ($this->buyerInfo != null) {
            $jsonObject["buyer_street"] = $this->buyerInfo->street;
            $jsonObject["buyer_building"] = $this->buyerInfo->buildingNumber;
            $jsonObject["buyer_plot_id"] = $this->buyerInfo->plotIdentification;
            $jsonObject["buyer_city_sub"] = $this->buyerInfo->citySubdivisionName;
            $jsonObject["buyer_city"] = $this->buyerInfo->cityName;
            $jsonObject["buyer_postal"] = $this->buyerInfo->postalZone;
            $jsonObject["buyer_country"] = $this->buyerInfo->country;
            $jsonObject["buyer_name"] = $this->buyerInfo->name;
            $jsonObject["buyer_vat_id"] = $this->buyerInfo->vatID;
            $jsonObject["buyer_id"] = $this->buyerInfo->id;
            $jsonObject["buyer_id_type"] = $this->buyerInfo->idType;
        }

        // Items
        if ($this->items != null) {
            $itemsArray = array();
            foreach ($this->items as $item) {
                $itemJson = array();
                $itemJson["name"] = $item->name;
                $itemJson["unit"] = $item->unit;
                $itemJson["quantity"] = $item->quantity;
                $itemJson["price"] = $item->price;
                $itemJson["discount"] = $item->discount;
                $itemJson["discount_reason"] = $item->discountReason;
                $itemJson["discount_reason_code"] = $item->discountReasonCode;
                $vc = "standard";
                if ($item->vatCategory == ZVatCategory::zero) {
                    $vc = "zero";
                } else if ($item->vatCategory == ZVatCategory::excempt) {
                    $vc = "exempt";
                } else if ($item->vatCategory == ZVatCategory::outOfScope) {
                    $vc = "out";
                }
                $itemJson["vat_cat"] = $vc;
                $itemJson["vat_rate"] = $item->vatRate;
                $itemsArray[] = $itemJson;
            }
            $jsonObject["items"] = $itemsArray;
        }

        // Additions
        if ($this->additions != null) {
            $additionsArray = array();
            foreach ($this->additions as $addition) {
                $additionJson = array();
                $additionJson["amount"] = $addition->amount;
                $additionJson["reason"] = $addition->reason;
                $additionJson["reason_code"] = $addition->reasonCode;
                $vc = "standard";
                if ($addition->vatCategory == ZVatCategory::zero) {
                    $vc = "zero";
                } else if ($addition->vatCategory == ZVatCategory::excempt) {
                    $vc = "exempt";
                } else if ($addition->vatCategory == ZVatCategory::outOfScope) {
                    $vc = "out";
                }
                $additionJson["vat_cat"] = $vc;
                $additionJson["vat_rate"] = $addition->vatRate;
                $additionsArray[] = $additionJson;
            }
            $jsonObject["additions"] = $additionsArray;
        }

        // Discounts
        if ($this->discounts != null) {
            $discountsArray = array();
            foreach ($this->discounts as $discount) {
                $discountJson = array();
                $discountJson["amount"] = $discount->amount;
                $discountJson["reason"] = $discount->reason;
                $vc = "standard";
                if ($discount->vatCategory == ZVatCategory::zero) {
                    $vc = "zero";
                } else if ($discount->vatCategory == ZVatCategory::excempt) {
                    $vc = "exempt";
                } else if ($discount->vatCategory == ZVatCategory::outOfScope) {
                    $vc = "out";
                }
                $discountJson["vat_cat"] = $vc;
                $discountJson["vat_rate"] = $discount->vatRate;
                $discountsArray[] = $discountJson;
            }
            $jsonObject["discounts"] = $discountsArray;
        }

        return $jsonObject;
    }
}

function postRequest($url, $data)
{
    $ch = curl_init($url);
    $jsonData = json_encode($data);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Content-Type: application/json; utf-8",
        "Accept: application/json"
    ));
    $response = curl_exec($ch);
    if ($response === false) {
        throw new Exception("Curl error: " . curl_error($ch));
    }
    curl_close($ch);
    return $response;
}

function sendBill($bill, $onboardingData, $lastHash, $seq)
{
    $j = $bill->toJSONObject();
    $j["onboarding_data"] = $onboardingData;
    $j["last_hash"] = $lastHash;
    $j["sequence"] = $seq;
    global $ZatcaServer;
    $url = "http://" . $ZatcaServer . ":8052/send";
    $response = postRequest($url, $j);
    $j = json_decode($response, true);
    return ZResult::fromJson($j);
}

function onboard(
    $otp,
    $vatID,
    $organization,
    $business,
    $country,
    $branchOrTIN,
    $address,
    $unitName,
    $appName,
    $appVersion,
    $appCopySN,
    $isProduction
) {
    $jsonParam = array();
    $jsonParam["otp"] = $otp;
    $jsonParam["vat_id"] = $vatID;
    $jsonParam["organization"] = $organization;
    $jsonParam["business"] = $business;
    $jsonParam["country"] = $country;
    $jsonParam["branch"] = $branchOrTIN;
    $jsonParam["address"] = $address;
    $jsonParam["unit_name"] = $unitName;
    $jsonParam["app_name"] = $appName;
    $jsonParam["app_version"] = $appVersion;
    $jsonParam["app_copy_sn"] = $appCopySN;
    $jsonParam["is_production"] = $isProduction;
    global $ZatcaServer;
    $url = "http://" . $ZatcaServer . ":8052/onboard";
    $response = postRequest($url, $jsonParam);
    $j = json_decode($response, true);
    $result = new ZOnboardingResult();
    $result->result = isset($j["result"]) ? $j["result"] : "";
    $result->errorMessage = isset($j["error_message"]) ? $j["error_message"] : "";
    $result->onboardingData = isset($j["onboarding_data"]) ? $j["onboarding_data"] : "";
    return $result;
}
