<?php

namespace App\Model\warehouse;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class warehouse extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    protected $guarded = [];
    protected $auditExclude = [
        'tenant_id',
        'company_id',
    ];

    public function warehouse_detail()
    {
        return $this->hasMany('App\Model\warehouse\warehouse_detail');
    }

    public function stock_adjustment()
    {
        return $this->hasMany('App\Model\stock_adjustment\stock_adjustment');
    }

    public function purchase_delivery()
    {
        return $this->hasMany('App\Model\purchase\purchase_delivery');
    }

    public function purchase_invoice()
    {
        return $this->hasMany('App\Model\purchase\purchase_invoice');
    }

    public function purchase_order()
    {
        return $this->hasMany('App\Model\purchase\purchase_order');
    }

    public function purchase_return()
    {
        return $this->hasMany('App\Model\purchase\purchase_return');
    }

    public function sale_delivery()
    {
        return $this->hasMany('App\Model\sales\sale_delivery');
    }

    public function sale_invoice()
    {
        return $this->hasMany('App\Model\sales\sale_invoice');
    }

    public function sale_order()
    {
        return $this->hasMany('App\Model\sales\sale_order');
    }

    public function sale_return()
    {
        return $this->hasMany('App\Model\sales\sale_return');
    }

    public function warehouse_transfer()
    {
        return $this->hasMany('App\Model\warehouse\warehouse_transfer');
    }

    public function spk()
    {
        return $this->hasMany('App\Model\spk\spk');
    }

    public function wip()
    {
        return $this->hasMany('App\Model\wip\wip');
    }
}
