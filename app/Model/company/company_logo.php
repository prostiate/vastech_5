<?php

namespace App\Model\company;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class company_logo extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $guarded = [];
    protected $auditExclude = [
        'tenant_id',
        'company_id',
    ];
}
