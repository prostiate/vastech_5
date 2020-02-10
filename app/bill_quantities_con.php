<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class bill_quantities_con extends Model
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

    public function bill_quantities_detail()
    {
        return $this->hasMany('App\bill_quantities_detail_con', 'bill_quantities_id');
    }

    public function budget_plan()
    {
        return $this->belongsTo('App\budget_plan_con', 'budget_plan_id');
    }
}
