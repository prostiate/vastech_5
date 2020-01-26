<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class product extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    protected $casts = ['qty' => 'float'];

    public function product_bundle_cost()
    {
        return $this->hasMany('App\product_bundle_cost');
    }

    public function product_bundle_item()
    {
        return $this->hasMany('App\product_bundle_item');
    }
    // PURCHASES
    public function purchase_delivery_item()
    {
        return $this->hasMany('App\purchase_delivery_item');
    }

    public function purchase_invoice_item()
    {
        return $this->hasMany('App\purchase_invoice_item');
    }

    public function purchase_order_item()
    {
        return $this->hasMany('App\purchase_order_item');
    }

    public function purchase_quote_item()
    {
        return $this->hasMany('App\purchase_quote_item');
    }
    // PURCHASES
    // SALES
    public function sale_delivery_item()
    {
        return $this->hasMany('App\sale_delivery_item');
    }

    public function sale_invoice_item()
    {
        return $this->hasMany('App\sale_invoice_item');
    }

    public function sale_order_item()
    {
        return $this->hasMany('App\sale_order_item');
    }

    public function sale_quote_item()
    {
        return $this->hasMany('App\sale_quote_item');
    }
    // SALES
    public function warehouse_detail()
    {
        return $this->hasMany('App\warehouse_detail');
    }

    public function lalawd()
    {
        return $this->hasMany('App\warehouse_detail')->selectRaw('SUM(qty_in - qty_out) as qty, product_id, id, warehouse_id')->groupBy('product_id');
    }

    public function wdhehe()
    {
        return $this->hasMany('App\warehouse_detail')->select(['qty_in', 'qty_out']);
    }

    public function spk_item()
    {
        return $this->hasMany('App\spk_item');
    }

    public function warehouse_transfer_item()
    {
        return $this->hasMany('App\warehouse_transfer_item');
    }

    public function wip_item()
    {
        return $this->hasMany('App\wip_item');
    }

    public function stock_adjustment_detail()
    {
        return $this->belongsTo('App\stock_adjustment_detail');
    }

    public function other_unit()
    {
        return $this->belongsTo('App\other_unit');
    }

    public function taxBuy()
    {
        return $this->belongsTo('App\other_tax', 'buy_tax');
    }

    public function taxSell()
    {
        return $this->belongsTo('App\other_tax', 'sell_tax');
    }

    public function other_product_category()
    {
        return $this->belongsTo('App\other_product_category');
    }

    public function coaBuyAccount()
    {
        return $this->belongsTo('App\coa', 'buy_account');
    }

    public function coaSellAccount()
    {
        return $this->belongsTo('App\coa', 'sell_account');
    }

    public function stock_adjustment()
    {
        return $this->belongsTo('App\stock_adjustment');
    }
}
