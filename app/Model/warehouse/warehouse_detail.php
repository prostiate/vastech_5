<?php

namespace App\Model\warehouse;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class warehouse_detail extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    protected $casts = [
        'qty_in' => 'float',
        'qty_out' => 'float',
        'qty_total' => 'float',
    ];

    public function product()
    {
        return $this->belongsTo('App\Model\product\product');
    }

    public function warehouse()
    {
        return $this->belongsTo('App\Model\warehouse\warehouse');
    }
}
