<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleBillPrintDemo extends Model
{
    protected $table = "sale_bill_print_demo";
    protected $fillable = [
        'company_id','client_id',
        'bill_date_ar','tax_number_ar','bill_id_ar','commercial_number_ar','civil_number_ar',
        'company_name_ar','company_address_ar','company_phone_number_ar','client_name_ar','outer_client_name_ar',
        'outer_client_address_ar','outer_client_phone_ar','outer_client_tax_number_ar','product_code_ar',
        'product_model_ar','product_name_ar','quantity_ar','unit_price_ar','quantity_price_ar',
        'bill_date_en','tax_number_en','bill_id_en','commercial_number_en','civil_number_en',
        'company_name_en','company_address_en','company_phone_number_en','client_name_en','outer_client_name_en',
        'outer_client_address_en','outer_client_phone_en','outer_client_tax_number_en','product_code_en',
        'product_model_en','product_name_en','quantity_en','unit_price_en','quantity_price_en',
    ];
    public function company(){
        return $this->belongsTo('\App\Models\Company','company_id','id');
    }
    public function client(){
        return $this->belongsTo('\App\Models\Client','client_id','id');
    }
}
