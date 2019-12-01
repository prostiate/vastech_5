<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class purchase_invoice_item extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function purchase_invoice()
    {
        return $this->belongsTo('App\purchase_invoice');
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
