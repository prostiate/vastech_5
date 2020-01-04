<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class purchase_return extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('App\user');
    }

    public function purchase_return_item()
    {
        return $this->hasMany('App\purchase_return_item');
    }

    public function purchase_invoice()
    {
        return $this->belongsTo('App\purchase_invoice', 'selected_pi_id');
    }

    public function contact()
    {
        return $this->belongsTo('App\contact');
    }

    public function warehouse()
    {
        return $this->belongsTo('App\warehouse');
    }

    public function transaction()
    {
        return $this->belongsTo('App\other_transaction');
    }

    public function status()
    {
        return $this->belongsTo('App\other_status', 'status');
    }
}
