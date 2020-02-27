<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class bill_quantities_detail_con extends Model
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

    public function bill_quantities()
    {
        return $this->belongsTo('App\bill_quantities_con', 'bill_quantities_id');
    }

    public function budget_plan_detail()
    {
        return $this->belongsTo('App\budget_plan_detail_con', 'budget_plan_detail_id');
    }

    public function offering_letter_detail()
    {
        return $this->belongsTo('App\offering_letter_detail_con', 'offering_letter_detail_id');
    }

    public function product()
    {
        return $this->belongsTo('App\product');
    }

    public function other_unit()
    {
        return $this->belongsTo('App\other_unit', 'unit_id');
    }
}
