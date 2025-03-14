<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Store;

class SaleBill extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $table = "sale_bills";
    protected $fillable = [
        'token',
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
        'value_added_tax',
        'total_tax',
    ];
    // protected static function boot()
    // {
    //     parent::boot();

    //     static::creating(function ($billSale) {
    //         $billSale->sale_bill_number = self::generateSaleBillNumber($billSale->company_id);
    //     });
    // }
    // public static function generateSaleBillNumber($companyId)
    // {
    //     $lastBill = self::where('company_id', $companyId)
    //                     ->orderBy('sale_bill_number', 'desc')
    //                     ->first();

    //     return $lastBill ? $lastBill->sale_bill_number + 1 : 1;
    // }
    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function elements()
    {
        return $this->hasMany('\App\Models\SaleBillElement', 'sale_bill_id', 'id');
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
}
