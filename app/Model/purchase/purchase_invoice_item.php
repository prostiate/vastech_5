<?php

namespace App\Model\purchase;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class purchase_invoice_item extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    protected $casts = [
        'qty' => 'float',
        'qty_remaining' => 'float',
        'qty_remaining_return' => 'float',
    ];

    public function purchase_invoice()
    {
        return $this->belongsTo('App\Model\purchase\purchase_invoice');
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
