<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $array)
 * @method static where(string $string, $id)
 * @method static findOrFail($client_id)
 */
class ClientProfile extends Model
{
    protected $table = 'client_profiles';
    protected $fillable = [
        'city_name',
        'age',
        'gender',
        'profile_pic',
        'client_id',
        'company_id'
    ];
    public function client()
    {
        return $this->belongsTo('\App\Models\Client');
    }
    public function company()
    {
        return $this->belongsTo('\App\Models\Company');
    }
}
