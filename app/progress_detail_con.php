<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class progress_detail_con extends Model
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

    public function progress()
    {
        return $this->belongsTo('App\progress_con', 'progress_id');
    }

    public function budget_plan_detail()
    {
        return $this->belongsTo('App\budget_plan_detail_con', 'budget_plan_detail_id');
    }
}
