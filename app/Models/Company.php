<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static FindOrFail($company_id)
 */
class Company extends Model
{
    protected $table = "companies";
    protected $fillable = [
        'company_name', 'business_field', 'phone_number', 'company_owner', 'company_address', 'country', 'currency',
        'tax_number', 'civil_registration_number', 'tax_value_added', 'company_logo', 'status', 'notes',
        'all_users_access_main_branch'
    ];

    public function print_demo()
    {
        return $this->hasOne('\App\Models\SaleBillPrintDemo', 'company_id', 'id');
    }

    public function subCategories()
    {
        return $this->hasMany('\App\Models\SubCategory', 'company_id', 'id');
    }

    public function coupons()
    {
        return $this->hasMany('\App\Models\CouponCode', 'company_id', 'id');
    }

    public function pos_bills()
    {
        return $this->hasMany('\App\Models\PosOpen', 'company_id', 'id');
    }

    public function pos()
    {
        return $this->hasMany('\App\Models\PosSettings', 'company_id', 'id');
    }

    public function units()
    {
        return $this->hasMany('\App\Models\Unit', 'company_id', 'id');
    }

    public function payments()
    {
        return $this->hasMany('\App\Models\Payment', 'company_id', 'id');
    }

    public function products()
    {
        return $this->hasMany('\App\Models\Product', 'company_id', 'id');
    }

    public function employees()
    {
        return $this->hasMany('\App\Models\Employee', 'company_id', 'id');
    }

    public function employees_cashs()
    {
        return $this->hasMany('\App\Models\EmployeeCash', 'company_id', 'id');
    }

    public function quotations()
    {
        return $this->hasMany('\App\Models\Quotation', 'company_id', 'id')->orderBy('id', 'DESC');
    }

    public function purchase_orders()
    {
        return $this->hasMany('\App\Models\PurchaseOrder', 'company_id', 'id');
    }

    public function sale_bills()
    {
        return $this->hasMany('\App\Models\SaleBill', 'company_id', 'id');
    }

    public function sale_bill_returns()
    {
        return $this->hasMany('\App\Models\SaleBillReturn', 'company_id', 'id');
    }

    public function buy_bill_returns()
    {
        return $this->hasMany('\App\Models\BuyBillReturn', 'company_id', 'id');
    }

    public function buy_bills()
    {
        return $this->hasMany('\App\Models\BuyBill', 'company_id', 'id');
    }

    public function outerClients()
    {
        return $this->hasMany('\App\Models\OuterClient', 'company_id', 'id');
    }

    public function clients()
    {
        return $this->hasMany('\App\Models\Client', 'company_id', 'id');
    }

    public function cashs()
    {
        return $this->hasMany('\App\Models\Cash', 'company_id', 'id');
    }

    public function buy_cashs()
    {
        return $this->hasMany('\App\Models\BuyCash', 'company_id', 'id');
    }

    public function suppliers()
    {
        return $this->hasMany('\App\Models\Supplier', 'company_id', 'id');
    }

    public function categories()
    {
        return $this->hasMany('\App\Models\Category', 'company_id', 'id');
    }

    public function capitals()
    {
        return $this->hasMany('\App\Models\Capital', 'company_id', 'id');
    }

    public function gifts()
    {
        return $this->hasMany('\App\Models\Gift', 'company_id', 'id');
    }

    public function expenses()
    {
        return $this->hasMany('\App\Models\Expense', 'company_id', 'id');
    }

    public function banks()
    {
        return $this->hasMany('\App\Models\Bank', 'company_id', 'id');
    }

    public function branches()
    {
        return $this->hasMany('\App\Models\Branch', 'company_id', 'id');
    }

    public function stores()
    {
        return $this->hasMany('\App\Models\Store', 'company_id', 'id');
    }

    public function safes()
    {
        return $this->hasMany('\App\Models\Safe', 'company_id', 'id');
    }

    public function fiscal()
    {
        return $this->hasOne('\App\Models\Fiscal', 'company_id', 'id');
    }

    public function taxes()
    {
        return $this->hasMany('\App\Models\Tax', 'company_id', 'id');
    }

    public function pos_settings()
    {
        return $this->hasOne('\App\Models\PosSetting', 'company_id', 'id');
    }

    public function subscription()
    {
        return $this->hasOne('\App\Models\Subscription', 'company_id', 'id');
    }

    public function fixed_expenses()
    {
        return $this->hasMany('\App\Models\FixedExpense', 'company_id', 'id');
    }

    public function basic_settings()
    {
        return $this->hasOne('\App\Models\BasicSettings', 'company_id', 'id');
    }

    public function email_settings()
    {
        return $this->hasOne('\App\Models\EmailSettings', 'company_id', 'id');
    }

    public function extra_settings()
    {
        return $this->hasOne('\App\Models\ExtraSettings', 'company_id', 'id');
    }

}
