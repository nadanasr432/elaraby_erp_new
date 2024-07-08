<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;
    protected $fillable = [
        'voucher_type',
        'referable_type',
        'amount',
        'payment_method',
        'notation',
        'status',
        'user_id',
        'company_id',
        'date',
        'options',
    ];
    public function accountingTree()
    {
        return $this->belongsTo(accounting_tree::class, 'account_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function referable()
    {
        return $this->morphTo();
    }

}
