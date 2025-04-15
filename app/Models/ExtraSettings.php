<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExtraSettings extends Model
{
    protected $table = "extra_settings";
    protected $fillable = [
        'company_id','timezone','currency','font_size', 'exp_duration','show_model'
    ];
    public function company(){
        return $this->belongsTo('\App\Models\Company','company_id','id');
    }
}
