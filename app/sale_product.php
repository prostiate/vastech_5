<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class sale_product extends Model
{
    protected $fillable = [
        'desc',
        'qty',
        'unit',
        'unit_price',
        'tax_id',
        'amount',
        'product_id'
    ];

    public function product()
    {
        return $this->belongsTo('App\product');
    } 

    public function sale_detail()
    {
        return $this->belongsTo('App\sale_detail');
    } 
}
