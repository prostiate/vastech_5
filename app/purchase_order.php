<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class purchase_order extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('App\user');
    }

    public function purchase_order_item()
    {
        return $this->hasMany('App\purchase_order_item');
    }

    public function purchase_delivery()
    {
        return $this->hasMany('App\purchase_delivery');
    }

    public function transaction()
    {
        return $this->belongsTo('App\other_transaction');
    }

    public function status()
    {
        return $this->belongsTo('App\other_status', 'status');
    }

    public function contact()
    {
        return $this->belongsTo('App\contact');
    }

    public function term()
    {
        return $this->belongsTo('App\other_term', 'term_id');
    }

    public function warehouse()
    {
        return $this->belongsTo('App\warehouse');
    }

    public function product()
    {
        return $this->belongsTo('App\product');
    }

    public function purchase_quote()
    {
        return $this->belongsTo('App\purchase_quote', 'selected_pq_id');
    }
}
