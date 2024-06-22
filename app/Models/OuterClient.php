<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OuterClient extends Model
{
    protected $table = "outer_clients";
    protected $fillable = [
        'company_id','client_id','client_name','client_category',
        'prev_balance','shop_name','client_email','client_national','tax_number'
    ];
    public function company(){
        return $this->belongsTo('\App\Models\Company','company_id','id');
    }
    public function client(){
        return $this->belongsTo('\App\Models\Client','client_id','id');
    }
    public function notes(){
        return $this->hasMany('\App\Models\OuterClientNote','outer_client_id','id');
    }
    public function pos_bills(){
        return $this->hasMany('\App\Models\PosOpen','outer_client_id','id');
    }
    public function phones(){
        return $this->hasMany('\App\Models\OuterClientPhone','outer_client_id','id');
    }
    public function addresses(){
        return $this->hasMany('\App\Models\OuterClientAddress','outer_client_id','id');
    }
    public function gifts(){
        return $this->hasMany('\App\Models\Gift','outer_client_id','id');
    }
    public function quotations(){
        return $this->hasMany('\App\Models\Quotation','outer_client_id','id');
    }
    public function saleBills(){
        return $this->hasMany('\App\Models\SaleBill','outer_client_id','id');
    }
    public function saleBillReturns(){
        return $this->hasMany('\App\Models\SaleBillReturn','outer_client_id','id');
    }
    public function cashs(){
        return $this->hasMany('\App\Models\Cash','outer_client_id','id');
    }
    public function bankcashs(){
        return $this->hasMany('\App\Models\BankCash','outer_client_id','id');
    }

}
