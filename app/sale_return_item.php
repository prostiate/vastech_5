<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class sale_return_item extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function sale_return()
    {
        return $this->belongsTo('App\sale_return');
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
