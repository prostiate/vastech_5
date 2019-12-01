<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class sale_return extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function sale_return_item()
    {
        return $this->hasMany('App\sale_return_item');
    }

    public function sale_invoice()
    {
        return $this->belongsTo('App\sale_invoice', 'selected_si_id');
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
