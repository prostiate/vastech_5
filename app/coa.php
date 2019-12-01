<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class coa extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function default_account()
    {
        return $this->hasMany('App\default_account');
    }

    public function coa_detail()
    {
        return $this->hasMany('App\coa_detail');
    }

    public function coa_category()
    {
        return $this->belongsTo('App\coa_category');
    }

    public function stock_adjustment()
    {
        return $this->hasMany('App\stock_adjustment');
    }

    public function contact()
    {
        return $this->hasMany('App\contact');
    }

    public function purchase_payment()
    {
        return $this->hasMany('App\purchase_payment');
    }

    public function cashbank()
    {
        return $this->hasMany('App\cashbank');
    }
}
