<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class purchase_order_item extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function purchase_order()
    {
        return $this->belongsTo('App\purchase_order');
    } 

    public function product()
    {
        return $this->belongsTo('App\product');
    } 

    public function unit()
    {
        return $this->belongsTo('App\other_unit');
    } 

    public function tax()
    {
        return $this->belongsTo('App\other_tax');
    } 
}
