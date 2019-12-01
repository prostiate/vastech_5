<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class sale_order extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function sale_order_item()
    {
        return $this->hasMany('App\sale_order_item');
    }

    public function sale_delivery()
    {
        return $this->hasMany('App\sale_delivery');
    }

    public function transaction()
    {
        return $this->belongsTo('App\other_transaction');
    }

    public function contact()
    {
        return $this->belongsTo('App\contact');
    }

    public function contact_marketting()
    {
        return $this->belongsTo('App\contact', 'marketting');
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

    public function status_order()
    {
        return $this->belongsTo('App\other_status', 'status');
    }

    public function sale_quote()
    {
        return $this->belongsTo('App\sale_quote', 'selected_sq_id');
    }
}
