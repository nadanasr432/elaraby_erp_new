<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleBill extends Model
{
    protected $table = "sale_bills";
    protected $fillable = [
        'token', 'company_id', 'company_counter', 'client_id', 'outer_client_id',
        'sale_bill_number', 'date', 'time', 'notes',
        'final_total', 'status', 'paid', 'rest', 'value_added_tax'
    ];

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
}
