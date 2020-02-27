<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class progress_con extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function tenant()
    {
        return $this->belongsTo('App\tenant');
    }

    public function company()
    {
        return $this->belongsTo('App\company');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function progress_detail()
    {
        return $this->hasMany('App\progress_detail_con', 'progress_id');
    }

    public function form_order()
    {
        return $this->belongsTo('App\form_order_con', 'form_order_id');
    }
}
