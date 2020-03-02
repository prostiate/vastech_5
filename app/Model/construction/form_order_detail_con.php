<?php

namespace App\Model\construction;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class form_order_detail_con extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    protected $guarded = [];
    protected $auditExclude = [
        'tenant_id',
        'company_id',
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

    public function budget_plan_detail()
    {
        return $this->belongsTo('App\Model\construction\budget_plan_detail_con', 'budget_plan_detail_id');
    }

    public function form_order()
    {
        return $this->belongsTo('App\Model\construction\form_order', 'form_order_id');
    }
}
