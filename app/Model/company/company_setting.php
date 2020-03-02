<?php

namespace App\Model\company;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class company_setting extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $guarded = [];
    protected $auditExclude = [
        'tenant_id',
        'company_id',
    ];
}
