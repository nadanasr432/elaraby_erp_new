<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;
    public function accountingTree()
    {
        return $this->belongsTo(accounting_tree::class, 'account_id');
    }
    protected $fillable = [
        'voucher_type',
        'referable_type',
        'amount',
        'payment_method',
        'notation',
        'status',
        'user_id',
        'date',
        'options',
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

}
