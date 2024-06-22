<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class CostCenter extends Model
{
    protected $table = 'cost_centers';
    protected $guarded = [];

    public function childs() {
        return $this->hasMany('App\Models\CostCenter','parent_id','id') ;
    }

    public function client() {
        return $this->belongsTo('App\Models\Client') ;
    }
}
