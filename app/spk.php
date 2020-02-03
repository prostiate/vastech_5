<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class spk extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('App\user');
    }

    public function spk_item()
    {
        return $this->hasMany('App\spk_item');
    }

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

    public function spk_status()
    {
        return $this->belongsTo('App\other_status', 'status');
    }
}
