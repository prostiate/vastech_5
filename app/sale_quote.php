<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class sale_quote extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('App\user');
    }
    
    public function sale_quote_item()
    {
        return $this->hasMany('App\sale_quote_item');
    }

    public function transaction()
    {
        return $this->belongsTo('App\other_transaction');
    }

    public function contact()
    {
        return $this->belongsTo('App\contact');
    }

    public function term()
    {
        return $this->belongsTo('App\other_term');
    }

    public function warehouse()
    {
        return $this->belongsTo('App\warehouse');
    }

    public function product()
    {
        return $this->belongsTo('App\product');
    }

    public function status()
    {
        return $this->belongsTo('App\other_status', 'status');
    }
}
