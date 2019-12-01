<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class stock_adjustment extends Model
{
    protected $guarded = [];

    public function stock_adjustment_detail()
    {
        return $this->hasMany('App\stock_adjustment_detail');
    }

    public function transaction()
    {
        return $this->belongsTo('App\other_transaction');
    }

    public function coa()
    {
        return $this->belongsTo('App\coa');
    }

    public function warehouse()
    {
        return $this->belongsTo('App\warehouse');
    }
}
