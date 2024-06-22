<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $array)
 * @method static where(string $string, $id)
 * @method static findOrFail($admin_id)
 */
class Contact extends Model
{
    protected $table = "contacts";
    protected $fillable = [
        'name','phone','subject','message','status'
    ];

}
