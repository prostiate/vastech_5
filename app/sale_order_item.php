<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class sale_order_item extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function sale_order()
    {
        return $this->belongsTo('App\sale_order');
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
