<?php

namespace App\Models;

use App\Models\Cash;
use App\Models\Store;
use App\Models\BankCash;
use App\Services\ZatcaService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SaleBill1 extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $table = "sale_bills";
    protected $fillable = [
        'token',
        'uuid',
        'company_id',
        'company_counter',
        'client_id',
        'outer_client_id',
        'sale_bill_number',
        'date',
        'time',
        'notes',
        'final_total',
        'status',
        'paid',
        'rest',
        'value_added_tax',
        'store_id',
        'total_discount',
        'products_discount_type',
        'total_tax',
        'zatca_status',
        'zatca_hash',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($billSale) {
            $billSale->sale_bill_number = self::generateSaleBillNumber($billSale->company_id);
            if (empty($billSale->uuid)) {
                $billSale->uuid = (string) \Illuminate\Support\Str::uuid();
            }
        });
    }
    public static function generateSaleBillNumber($companyId)
    {
        $lastBill = self::where('company_id', $companyId)
            ->orderBy('sale_bill_number', 'desc')
            ->first();

        return $lastBill ? $lastBill->sale_bill_number + 1 : 1;
    }
    public function store()
    {
        return $this->belongsTo(Store::class);
    }
    public function elements()
    {
        return $this->hasMany('\App\Models\SaleBillElement1', 'sale_bill_id', 'id');
    }

    public function extras()
    {
        return $this->hasMany('\App\Models\SaleBillExtra', 'sale_bill_id', 'id');
    }

    public function sale_bill_notes()
    {
        return $this->hasMany('\App\Models\SaleBillNote', 'sale_bill_id', 'id');
    }

    public function company()
    {
        return $this->belongsTo('\App\Models\Company', 'company_id', 'id');
    }

    public function outerClient()
    {
        return $this->belongsTo('\App\Models\OuterClient', 'outer_client_id', 'id');
    }

    public function client()
    {
        return $this->belongsTo('\App\Models\Client', 'client_id', 'id');
    }
    public function vouchers()
    {
        return $this->morphMany(Voucher::class, 'referable');
    }
    public function getPaymentMethodAttribute()
    {
        $voucher = $this->vouchers()
            ->where('referable_id', $this->id)
            ->where('referable_type', self::class)
            ->first();

        if ($voucher && !empty($voucher->payment_method)) {
            if ($voucher->payment_method === 'cash') {
                return __('main.cash');
            } elseif ($voucher->payment_method === 'bank') {
                return __('main.bank');
            }
        }

        $bankCash = BankCash::where('bill_id', $this->id)
            ->where('company_id', $this->company_id)
            ->where('client_id', $this->client_id)
            ->where('outer_client_id', $this->outer_client_id)
            ->first();

        $cash = Cash::where('bill_id', $this->id)
            ->where('company_id', $this->company_id)
            ->where('client_id', $this->client_id)
            ->where('outer_client_id', $this->outer_client_id)
            ->first();

        if ($bankCash) {
            return __('main.bank');
        } elseif ($cash) {
            return __('main.cash');
        } else {
            return __('main.deferred');
        }
    }

    public function prepareBillData()
    {
        return [
            'uuid' => $this->uuid,
            'invoice_number' => $this->sale_bill_number,
            'date' => $this->date,
            'time' => $this->time,
            'customer_name' => optional($this->client ?? $this->outerClient)->name ?? 'Unknown',
            'payment_method' => $this->payment_method,
            'store' => optional($this->store)->store_name,
            'notes' => $this->notes,
            'total' => $this->final_total,
            'value_added_tax' => $this->value_added_tax,
            'total_tax' => $this->total_tax,
            'total_discount' => $this->total_discount,
            'products' => $this->elements->map(function ($element) {
                return [
                    'product_name' => $element->product_name ?? '', // adjust based on your actual field
                    'unit_price' => $element->unit_price,
                    'quantity' => $element->qty,
                    'discount' => $element->discount_value ?? 0,
                    'tax' => $element->tax_value ?? 0,
                    'total' => $element->quantity_price, // or whatever field represents row total
                ];
            }),
        ];
    }
    public function getCompany()
    {
        return $this->company; // Assuming a relation exists
    }

    public function getLastHash()
    {
        // Fetch last invoice hash, e.g., from DB
        return SaleBill1::latest()->value('zatca_hash');
    }
    // public function dispatchToZatca()
    // {
    //     $this->load([
    //         'company',
    //         'client',
    //         'outerClient',
    //         'elements.product',
    //         'elements.unit',
    //         'extras',
    //         'vouchers'
    //     ]);

    //     // Call your ZATCA service
    //     app(ZatcaService::class)->sendBill($this);
    // }
}
