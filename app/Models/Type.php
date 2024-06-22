<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $table = "types";
    protected $fillable = [
        'type_name','type_price','period','package_id'
    ];
    public function package(){
        return $this->belongsTo('\App\Models\Package','package_id','id');
    }
}
