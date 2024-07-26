<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuildingRole extends Model
{
    use HasFactory;
    protected $fillable = ['description_ar', 'description_en', 'code'];
}
