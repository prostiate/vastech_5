<?php

namespace App\Model\sales;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class sale_order_item extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    protected $casts = [
        'qty' => 'float',
        'qty_remaining' => 'float',
    ];

    public function sale_order()
    {
        return $this->belongsTo('App\Model\sales\sale_order');
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
