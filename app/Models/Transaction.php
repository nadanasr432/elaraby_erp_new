<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'voucher_id',
        'accounting_tree_id',
        'amount',
        'notation',
        'type'
    ];

      public function voucher()
      {
          return $this->belongsTo(Voucher::class);
      }

      public function accountingTree()
      {
          return $this->belongsTo(accounting_tree::class);
      }
}
