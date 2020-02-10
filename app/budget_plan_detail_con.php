<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class budget_plan_detail_con extends Model
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

    public function budget_plan()
    {
        return $this->belongsTo('App\budget_plan_con', 'budget_plan_id');
    }

    public function offering_letter_detail()
    {
        return $this->belongsTo('App\offering_letter_detail_con', 'offering_letter_detail_id');
    }
}
