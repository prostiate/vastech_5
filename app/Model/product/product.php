<?php

namespace App\Model\product;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class product extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    protected $guarded = [];
    protected $auditExclude = [
        'tenant_id',
        'company_id',
    ];
    protected $casts = ['qty' => 'float'];

    public function product_bundle_cost()
    {
        return $this->hasMany('App\Model\product\product_bundle_cost');
    }

    public function product_bundle_item()
    {
        return $this->hasMany('App\Model\product\product_bundle_item');
    }
    // PURCHASES
    public function purchase_delivery_item()
    {
        return $this->hasMany('App\Model\purchase\purchase_delivery_item');
    }

    public function purchase_invoice_item()
    {
        return $this->hasMany('App\Model\purchase\purchase_invoice_item');
    }

    public function purchase_order_item()
    {
        return $this->hasMany('App\Model\purchase\purchase_order_item');
    }

    public function purchase_quote_item()
    {
        return $this->hasMany('App\Model\purchase\purchase_quote_item');
    }
    // PURCHASES
    // SALES
    public function sale_delivery_item()
    {
        return $this->hasMany('App\Model\sales\sale_delivery_item');
    }

    public function sale_invoice_item()
    {
        return $this->hasMany('App\Model\sales\sale_invoice_item');
    }

    public function sale_order_item()
    {
        return $this->hasMany('App\Model\sales\sale_order_item');
    }

    public function sale_quote_item()
    {
        return $this->hasMany('App\Model\sales\sale_quote_item');
    }
    // SALES
    public function warehouse_detail()
    {
        return $this->hasMany('App\Model\warehouse\warehouse_detail');
    }

    public function lalawd()
    {
        return $this->hasMany('App\Model\warehouse\warehouse_detail')->selectRaw('SUM(qty_in - qty_out) as qty, product_id, id, warehouse_id')->groupBy('product_id');
    }

    public function wdhehe()
    {
        return $this->hasMany('App\Model\warehouse\warehouse_detail')->select(['qty_in', 'qty_out']);
    }

    public function spk_item()
    {
        return $this->hasMany('App\Model\spk\spk_item');
    }

    public function warehouse_transfer_item()
    {
        return $this->hasMany('App\Model\warehouse\warehouse_transfer_item');
    }

    public function wip_item()
    {
        return $this->hasMany('App\Model\wip\wip_item');
    }

    public function stock_adjustment_detail()
    {
        return $this->belongsTo('App\Model\stock_adjustment\stock_adjustment_detail');
    }

    public function other_unit()
    {
        return $this->belongsTo('App\Model\other\other_unit');
    }

    public function taxBuy()
    {
        return $this->belongsTo('App\Model\other\other_tax', 'buy_tax');
    }

    public function taxSell()
    {
        return $this->belongsTo('App\Model\other\other_tax', 'sell_tax');
    }

    public function other_product_category()
    {
        return $this->belongsTo('App\Model\other\other_product_category');
    }

    public function coaBuyAccount()
    {
        return $this->belongsTo('App\Model\coa\coa', 'buy_account');
    }

    public function coaSellAccount()
    {
        return $this->belongsTo('App\Model\coa\coa', 'sell_account');
    }

    public function stock_adjustment()
    {
        return $this->belongsTo('App\Model\stock_adjustment\stock_adjustment');
    }
}
