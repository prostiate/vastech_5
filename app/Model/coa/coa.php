<?php

namespace App\Model\coa;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class coa extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    protected $guarded = [];
    protected $auditExclude = [
        'tenant_id',
        'company_id',
    ];

    public function default_account()
    {
        return $this->hasMany('App\Model\coa\default_account');
    }

    public function coa_detail()
    {
        return $this->hasMany('App\Model\coa\coa_detail');
    }

    public function coa_category()
    {
        return $this->belongsTo('App\Model\coa\coa_category');
    }

    public function stock_adjustment()
    {
        return $this->hasMany('App\Model\stock_adjustment\stock_adjustment');
    }

    public function contact()
    {
        return $this->hasMany('App\Model\contact\contact');
    }

    public function purchase_payment()
    {
        return $this->hasMany('App\Model\purchase\purchase_payment');
    }

    public function cashbank()
    {
        return $this->hasMany('App\Model\cashbank\cashbank');
    }
}
