<?php

namespace App\Model\purchase;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class purchase_return_item extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    protected $casts = [
        'qty' => 'float',
        'qty_invoice' => 'float',
        'qty_remaining_invoice' => 'float',
    ];

    public function purchase_return()
    {
        return $this->belongsTo('App\Model\purchase\purchase_return');
    } 

    public function product()
    {
        return $this->belongsTo('App\Model\product\product');
    } 

    public function unit()
    {
        return $this->belongsTo('App\Model\other\other_unit');
    } 

    public function tax()
    {
        return $this->belongsTo('App\Model\other\other_tax');
    } 
}
