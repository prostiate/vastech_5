<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class purchase_invoice extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('App\user');
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

    public function transaction()
    {
        return $this->belongsTo('App\other_transaction');
    }

    public function purchase_invoice_item()
    {
        return $this->hasMany('App\purchase_invoice_item');
    }

    public function status()
    {
        return $this->belongsTo('App\other_status', 'status');
    }

    public function purchase_delivery()
    {
        return $this->belongsTo('App\purchase_delivery', 'selected_pd_id');
    }

    public function purchase_return()
    {
        return $this->belongsTo('App\purchase_return', 'selected_pr_id');
    }
}
