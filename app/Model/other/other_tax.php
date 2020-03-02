<?php

namespace App\Model\other;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class other_tax extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    protected $guarded = [];
    protected $auditExclude = [
        'tenant_id',
        'company_id',
        'status'
    ];

    public function coa_sell()
    {
        return $this->belongsTo('App\Model\coa\coa', 'sell_tax_account');
    }

    public function coa_buy()
    {
        return $this->belongsTo('App\Model\coa\coa', 'buy_tax_account');
    }

    public function purchase_delivery_item()
    {
        return $this->hasMany('App\Model\purchase\purchase_delivery_item', 'tax_id');
    }

    public function purchase_invoice_item()
    {
        return $this->hasMany('App\Model\purchase\purchase_invoice_item', 'tax_id');
    }

    public function purchase_order_item()
    {
        return $this->hasMany('App\Model\purchase\purchase_order_item', 'tax_id');
    }

    public function purchase_quote_item()
    {
        return $this->hasMany('App\Model\purchase\purchase_quote_item', 'tax_id');
    }

    public function purchase_return_item()
    {
        return $this->hasMany('App\Model\purchase\purchase_return_item');
    }

    public function sale_delivery_item()
    {
        return $this->hasMany('App\Model\sales\sale_delivery_item', 'tax_id');
    }

    public function sale_invoice_item()
    {
        return $this->hasMany('App\Model\sales\sale_invoice_item', 'tax_id');
    }

    public function sale_order_item()
    {
        return $this->hasMany('App\Model\sales\sale_order_item', 'tax_id');
    }

    public function sale_quote_item()
    {
        return $this->hasMany('App\Model\sales\sale_quote_item', 'tax_id');
    }

    public function sale_return_item()
    {
        return $this->hasMany('App\Model\sales\sale_return_item');
    }

    public function cashbank_item()
    {
        return $this->hasMany('App\Model\cashbank\cashbank_item', 'tax_id');
    }

    public function coa()
    {
        return $this->hasMany('App\Model\coa\coa', 'tax_id');
    }
}
