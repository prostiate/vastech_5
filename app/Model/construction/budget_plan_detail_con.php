<?php

namespace App\Model\construction;

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
        return $this->belongsTo('App\Model\company\company');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function budget_plan_area()
    {
        return $this->belongsTo('App\Model\construction\budget_plan_area_con', 'budget_plan_area_id');
    }

    public function product()
    {
        return $this->belongsTo('App\Model\product\product', 'product_id');
    }

    public function unit()
    {
        return $this->belongsTo('App\Model\other\other_unit', 'unit_id');
    }
}
