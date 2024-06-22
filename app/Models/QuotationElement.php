<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuotationElement extends Model
{
    protected $table = "quotations_elements";
    protected $fillable = [
        'quotation_id','company_id','product_id','product_price','quantity','unit_id','quantity_price'
    ];
    public function unit(){
        return $this->belongsTo('\App\Models\Unit','unit_id','id');
    }
    public function quotation(){
        return $this->belongsTo('\App\Models\Quotation','quotation_id','id');
    }
    public function product(){
        return $this->belongsTo('\App\Models\Product','product_id','id');
    }

    public function company(){
        return $this->belongsTo('\App\Models\Company','company_id','id');
    }
}
