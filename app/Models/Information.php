<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $array)
 * @method static where(string $string, $id)
 * @method static findOrFail($admin_id)
 * @method static First()
 */
class Information extends Model
{
    protected $table = "information";
    protected $fillable = [
        'email_link','facebook_link','whatsapp_message','whatsapp_number','admin_id'
    ];
    public function admin(){
        return $this->belongsTo('\App\Models\Admin','admin_id','id');
    }

}
