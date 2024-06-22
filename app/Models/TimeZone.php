<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimeZone extends Model
{
    protected $table = "timezones";
    protected $fillable = [
        'timezone','country_name'
    ];
}
