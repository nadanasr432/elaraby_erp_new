<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'settings';

    protected $fillable = [
        'company_id',
        'key',
        'value',
        'type',
    ];

    // Automatically cast 'value' attribute to array if it's JSON encoded
    protected $casts = [
        'value' => 'json',
    ];

    public function scopeOfCompanyKeyAndType($query, int $companyId, string $key, string $type)
    {
        return $query->where('company_id', $companyId)
            ->where('key', $key)
            ->where('type', $type);
    }
}
