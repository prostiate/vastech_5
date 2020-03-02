<?php

namespace App\Model\other;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class other_unit extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    protected $guarded = [];
    protected $auditExclude = [
        'tenant_id',
        'company_id',
        'status'
    ];

    public function product()
    {
        return $this->hasMany('App\Model\product\product');
    }

    public function purchase_delivery_item()
    {
        return $this->hasMany('App\Model\purchase\purchase_delivery_item', 'unit_id');
    }

    public function purchase_invoice_item()
    {
        return $this->hasMany('App\Model\purchase\purchase_invoice_item', 'unit_id');
    }

    public function purchase_order_item()
    {
        return $this->hasMany('App\Model\purchase\purchase_order_item', 'unit_id');
    }

    public function purchase_quote_item()
    {
        return $this->hasMany('App\Model\purchase\purchase_quote_item', 'unit_id');
    }

    public function sale_delivery_item()
    {
        return $this->hasMany('App\Model\sales\sale_delivery_item', 'unit_id');
    }

    public function sale_invoice_item()
    {
        return $this->hasMany('App\Model\sales\sale_invoice_item', 'unit_id');
    }

    public function sale_order_item()
    {
        return $this->hasMany('App\Model\sales\sale_order_item', 'unit_id');
    }

    public function sale_quote_item()
    {
        return $this->hasMany('App\Model\sales\sale_quote_item', 'unit_id');
    }
}
