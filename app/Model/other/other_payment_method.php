<?php

namespace App\Model\other;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class other_payment_method extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    protected $guarded = [];
    protected $auditExclude = [
        'tenant_id',
        'company_id',
        'status'
    ];
    public function purchase_payment()
    {
        return $this->hasMany('App\Model\purchase\purchase_payment');
    }

    public function sale_payment()
    {
        return $this->hasMany('App\Model\sales\sale_payment');
    }
}
