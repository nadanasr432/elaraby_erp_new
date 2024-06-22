<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class CouponCode extends Model
{
    protected $table = "coupon_codes";
    protected $fillable = [
        'company_id','client_id','dept','outer_client_id','category_id',
        'product_id','coupon_code','coupon_value','coupon_expired','status'
    ];
    public function company(){
        return $this->belongsTo('\App\Models\Company','company_id','id');
    }
    public function client(){
        return $this->belongsTo('\App\Models\Client','client_id','id');
    }
    public function outerClient(){
        return $this->belongsTo('\App\Models\OuterClient','outer_client_id','id');
    }
    public function category(){
        return $this->belongsTo('\App\Models\Category','category_id','id');
    }
    public function product(){
        return $this->belongsTo('\App\Models\Product','product_id','id');
    }
}
