<?php

namespace App\Model\sales;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class sale_delivery_item extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    protected $casts = [
        'qty' => 'float',
        'qty_remaining' => 'float',
    ];

    public function sale_delivery()
    {
        return $this->belongsTo('App\Model\sales\sale_delivery');
    } 

    public function sale_order_item()
    {
        return $this->belongsTo('App\Model\sales\sale_order_item');
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
