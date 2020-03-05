<?php

namespace App\Model\construction;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class bill_quantities_detail_con extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    protected $guarded = [];
    protected $auditExclude = [
        'tenant_id',
        'company_id'
    ];
    protected $casts = [
        'qty' => 'float',
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

    public function bill_quantities()
    {
        return $this->belongsTo('App\Model\construction\bill_quantities_con', 'bill_quantities_id');
    }

    public function budget_plan_detail()
    {
        return $this->belongsTo('App\Model\construction\budget_plan_detail_con', 'budget_plan_detail_id');
    }

    public function offering_letter_detail()
    {
        return $this->belongsTo('App\Model\construction\offering_letter_detail_con', 'offering_letter_detail_id');
    }

    public function product()
    {
        return $this->belongsTo('App\Model\product\product');
    }

    public function other_unit()
    {
        return $this->belongsTo('App\Model\other\other_unit', 'unit_id');
    }
}
