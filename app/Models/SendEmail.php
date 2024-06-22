<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $array)
 * @method static where(string $string, $id)
 * @method static findOrFail($admin_id)
 */
class SendEmail extends Model
{
    protected $table = "send_emails";
    protected $fillable = [
        'send_email','send_subject','send_message'
    ];

}
