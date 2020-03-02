<?php

namespace App\Model\construction;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class form_order_con extends Model implements Auditable
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

    public function form_order_detail()
    {
        return $this->hasMany('App\Model\construction\form_order_detail_con', 'form_order_id');
    }

    public function bill_quantities()
    {
        return $this->belongsTo('App\Model\construction\bill_quantities_con', 'bill_quantities_id');
    }
}
