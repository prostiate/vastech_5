<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class wip extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function wip_item()
    {
        return $this->hasMany('App\wip_item');
    }

    public function spk_item()
    {
        return $this->hasMany('App\spk_item');
    }

    public function spk()
    {
        return $this->belongsTo('App\spk', 'selected_spk_id');
    }

    public function contact()
    {
        return $this->belongsTo('App\contact', 'contact_id');
    }

    public function product()
    {
        return $this->belongsTo('App\product', 'result_product');
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
}
