<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    protected $table = "sub_categories";
    protected $fillable = [
        'company_id','category_id','sub_category_name'
    ];
    public function company(){
        return $this->belongsTo('\App\Models\Company','company_id','id');
    }
    public function category(){
        return $this->belongsTo('\App\Models\Category','category_id','id');
    }
}
