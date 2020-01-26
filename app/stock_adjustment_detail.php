<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class stock_adjustment_detail extends Model
{
    protected $guarded = [];
    protected $casts = [
        'recorded' => 'float',
        'actual' => 'float',
        'difference' => 'float',
    ];

    public function stock_adjustment()
    {
        return $this->belongsTo('App\stock_adjustment');
    } 

    public function warehouse()
    {
        return $this->belongsTo('App\warehouse');
    } 

    public function product()
    {
        return $this->belongsTo('App\product');
    } 
}
