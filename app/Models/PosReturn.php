<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PosReturn extends Model
{
    protected $table = 'pos_returns';
    protected $fillable = [
        'pos_open_id',
        'company_id',
        'client_id',
        'outer_client_id',
        'tableNum',
        'notes',
        'status',
        'value_added_tax',
        'total_amount',
        'tax_amount',
        'tax_value',
        'company_counter',
        'returned_at'
    ];
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($posOpen) {
            if (is_null($posOpen->company_counter)) {
                $maxCounter = static::where('company_id', $posOpen->company_id)
                    ->max('company_counter') ?? 0;
                $posOpen->company_counter = $maxCounter + 1;
            }
        });
    }
    public function elements()
    {
        return $this->hasMany(PosReturnElement::class, 'pos_return_id', 'id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }

    public function outerClient()
    {
        return $this->belongsTo(OuterClient::class, 'outer_client_id', 'id');
    }

    public function posOpen()
    {
        return $this->belongsTo(PosOpen::class, 'pos_open_id', 'id');
    }

    public function vouchers()
    {
        return $this->morphMany(Voucher::class, 'referable');
    }
}
