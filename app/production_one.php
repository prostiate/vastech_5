<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class production_one extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function contact()
    {
        return $this->belongsTo('App\contact', 'contact_id');
    }

    public function other_transaction()
    {
        return $this->belongsTo('App\other_transaction');
    }

    public function warehouse()
    {
        return $this->belongsTo('App\warehouse');
    }

    public function status()
    {
        return $this->belongsTo('App\other_status', 'status');
    }

    public function unit()
    {
        return $this->belongsTo('App\other_unit');
    }

    public function product()
    {
        return $this->belongsTo('App\product');
    }

    public function production_one_item()
    {
        return $this->hasMany('App\production_one_item');
    }

    public function production_one_cost()
    {
        return $this->hasMany('App\production_one_cost');
    }
}
