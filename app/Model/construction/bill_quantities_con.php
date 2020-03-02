<?php

namespace App\Model\construction;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class bill_quantities_con extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    protected $guarded = [];
    protected $auditExclude = [
        'tenant_id',
        'company_id',
        'status'
    ];

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

    public function bill_quantities_detail()
    {
        return $this->hasMany('App\Model\construction\bill_quantities_detail_con', 'bill_quantities_id');
    }

    public function budget_plan()
    {
        return $this->belongsTo('App\Model\construction\budget_plan_con', 'budget_plan_id');
    }

    public function form_order()
    {
        return $this->hasMany('App\Model\construction\form_order_con');
    }
}
