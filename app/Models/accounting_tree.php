<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class accounting_tree extends Model
{
    protected $guarded = [];

    public function childs() {
        return $this->hasMany('App\Models\accounting_tree','parent_id','id') ;
    }
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
