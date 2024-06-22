<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ElectronicStamps extends Model
{
    protected $table = "electronic_stamps";
    protected $fillable = [
        'name','company_id'
    ];
}
