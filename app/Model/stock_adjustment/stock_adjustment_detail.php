<?php

namespace App\Model\stock_adjustment;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class stock_adjustment_detail extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    protected $casts = [
        'recorded' => 'float',
        'actual' => 'float',
        'difference' => 'float',
    ];

    public function stock_adjustment()
    {
        return $this->belongsTo('App\Model\stock_adjustment\stock_adjustment');
    } 

    public function warehouse()
    {
        return $this->belongsTo('App\Model\warehouse\warehouse');
    } 

    public function product()
    {
        return $this->belongsTo('App\Model\product\product');
    } 
}
