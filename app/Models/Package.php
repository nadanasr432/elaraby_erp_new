<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $table = "packages";
    protected $fillable = [
        'package_name', 'users_count', 'employees_count', 'outer_clients_count', 'suppliers_count',
        'bills_count', 'products', 'debt', 'banks_safes', 'sales', 'purchases', 'finance', 'marketing', 'accounting',
        'reports','settings'
    ];

}
