<?php

namespace App\Model\construction;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class budget_plan_detail_con extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    protected $guarded = [];
    protected $auditExclude = [
        'tenant_id',
        'company_id'
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

    public function budget_plan()
    {
        return $this->belongsTo('App\Model\construction\budget_plan_con', 'budget_plan_id');
    }

    public function offering_letter_detail()
    {
        return $this->belongsTo('App\Model\construction\offering_letter_detail_con', 'offering_letter_detail_id');
    }
}
