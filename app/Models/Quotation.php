<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    protected $table = "quotations";
    protected $fillable = [
        'company_id','client_id','outer_client_id','quotation_number','start_date','expiration_date','notes'
    ];
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($quotationBill) {
            $quotationBill->quotation_number = self::generateSaleBillNumber($quotationBill->company_id);
        });
    }
    public static function generateSaleBillNumber($companyId)
    {
        $lastBill = self::where('company_id', $companyId)
            ->orderBy('quotation_number', 'desc')
            ->first();

        return $lastBill ? $lastBill->quotation_number + 1 : 1;
    }
    public function elements(){
        return $this->hasMany('\App\Models\QuotationElement','quotation_id','id');
    }
    public function extras(){
        return $this->hasMany('\App\Models\QuotationExtra','quotation_id','id');
    }
    public function company(){
        return $this->belongsTo('\App\Models\Company','company_id','id');
    }
    public function outerClient(){
        return $this->belongsTo('\App\Models\OuterClient','outer_client_id','id');
    }
    public function client(){
        return $this->belongsTo('\App\Models\Client','client_id','id');
    }
}
