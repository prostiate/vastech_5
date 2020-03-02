<?php

namespace App\Model\construction;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class offering_letter_con extends Model implements Auditable
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

    public function other_status()
    {
        return $this->belongsTo('App\Model\other\other_status', 'status');
    }

    public function offering_letter_detail()
    {
        return $this->hasMany('App\Model\construction\offering_letter_detail_con', 'offering_letter_id');
    }

    public function budget_plan()
    {
        return $this->hasMany('App\Model\construction\budget_plan_con', 'budget_plan_id');
    }
}
