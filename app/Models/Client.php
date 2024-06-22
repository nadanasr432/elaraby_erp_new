<?php
namespace App\Models;
use App\Notifications\ResetPasswordNotification;
use App\Notifications\VerifyEmailNotification;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

/**
 * @method static create(array $array)
 * @method static find(int $id)
 * @method static select(string $string)
 * @method static findOrFail($id)
 * @method static where(string $string, $id)
 * @method static get()
 */
class Client extends Authenticatable
{
    use Notifiable,HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'clients';
    protected $guard = 'client-web';
    protected $guard_name = 'client-web';

    protected $fillable = [
        'name', 'email', 'password','role_name','Status','phone_number','company_id','branch_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'role_name' => 'array',
    ];

    public function profile()
    {
        return $this->hasOne('\App\Models\ClientProfile');
    }
    public function company(){
        return $this->belongsTo('\App\Models\Company','company_id','id');
    }
    public function branch(){
        return $this->belongsTo('\App\Models\Branch','branch_id','id');
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token, 'client.password.reset', 'clients'));
    }

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmailNotification('client.verification.verify'));
    }
}


