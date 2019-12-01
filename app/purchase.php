<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class purchase extends Model
{
    protected $fillable = [
        'purchase_id',
        'type',
        'status',
        'prev_status',
    ];

    public function purchase_order()
    {
        return $this->hasMany('App\purchase_order');
    }

    public function purchase_quote()
    {
        return $this->hasMany('App\purchase_quote');
    } 

    public function purchase_invoice()
    {
        return $this->hasMany('App\purchase_invoice');
    } 

    public function purchase_delivery()
    {
        return $this->hasMany('App\purchase_delivery');
    } 

    public function purchase_product()
    {
        return $this->hasMany('App\purchase_product');
    } 

    public function product()
    {
        return $this->belongsTo('App\product');
    } 
}
