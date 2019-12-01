<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class purchase_product extends Model
{
    protected $fillable = [
        'desc',
        'qty',
        'unit_id',
        'unit_price',
        'tax_id',
        'amount',
        'product_id'
    ];

    public function product()
    {
        return $this->belongsTo('App\product');
    } 

    public function unit()
    {
        return $this->belongsTo('App\unit');
    } 

    public function purchase_detail()
    {
        return $this->belongsTo('App\purchase_detail');
    } 
}
