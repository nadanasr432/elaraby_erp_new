<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class OuterClientAddress extends Model
{
    protected $table = "outer_client_address";
    protected $fillable = [
        'outer_client_id','client_address','company_id'
    ];

    public function outer_client(){
        return $this->belongsTo('\App\Models\OuterClient','outer_client_id','id');
    }
    public function company(){
        return $this->belongsTo('\App\Models\Company','company_id','id');
    }
}
