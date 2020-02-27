<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class form_order_detail_con extends Model
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

    public function budget_plan_detail()
    {
        return $this->belongsTo('App\budget_plan_detail_con', 'budget_plan_detail_id');
    }

    public function form_order()
    {
        return $this->belongsTo('App\form_order', 'form_order_id');
    }
}
