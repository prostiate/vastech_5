<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class sale_detail extends Model
{
    protected $fillable = [
        'sale_id',
        'type',
        'status',
        'isQuoted',
        'isOrdered',
        'isDeliveried',
        'isInvoiced',
        'isPaid',
        'isQClose',
        'isOClose',
        'isDClose',
        'isIClose'
    ];

    public function sale_order()
    {
        return $this->hasMany('App\sale_order');
    }

    public function sale_quote()
    {
        return $this->hasMany('App\sale_quote');
    } 

    public function sale_invoice()
    {
        return $this->hasMany('App\sale_invoice');
    } 

    public function sale_delivery()
    {
        return $this->hasMany('App\sale_delivery');
    } 

    public function sale_product()
    {
        return $this->hasMany('App\sale_product');
    } 

    public function product()
    {
        return $this->belongsTo('App\product');
    } 

    public function coa_detail()
    {
        return $this->hasMany('App\coa_detail');
    } 
}
