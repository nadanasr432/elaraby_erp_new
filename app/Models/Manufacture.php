<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manufacture extends Model
{
    use HasFactory;
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($manufacture) {
            $manufacture->number = self::generateManufactureNumber($manufacture->company_id);
        });
    }
    public static function generateManufactureNumber($companyId)
    {
        $lastManufacture = self::where('company_id', $companyId)
            ->orderBy('number', 'desc')
            ->first();

        return $lastManufacture ? $lastManufacture->number + 1 : 1;
    }
    protected $fillable = [
        'company_id',
        'number',
        'store_id',
        'status',
        'date',
        'qty',
        'note',
        'total'
    ];

    public function products()
    {
        return $this->hasMany(ManufactureProduct::class);
    }
    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
