<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class offering_letter_detail_con extends Model
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

    public function other_status()
    {
        return $this->belongsTo('App\other_status', 'status');
    }

    public function offering_letter()
    {
        return $this->belongsTo('App\offering_letter_con', 'offering_letter_id');
    }

    public function budget_plan_detail()
    {
        return $this->hasMany('App\budget_plan_detail_con', 'offering_letter_detail_id');
    }
}
