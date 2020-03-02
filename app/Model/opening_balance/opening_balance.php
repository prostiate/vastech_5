<?php

namespace App\Model\opening_balance;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class opening_balance extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $guarded = [];
    protected $auditExclude = [
        'tenant_id',
        'company_id',
    ];

    public function opening_balance_detail()
    {
        return $this->hasMany('App\Model\opening_balance\opening_balance_detail');
    }
}
