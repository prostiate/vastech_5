<?php

namespace App\Model\contact;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class history_limit_balance extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    protected $guarded = [];
    protected $auditExclude = [
        'tenant_id',
        'company_id',
    ];

    public function contact()
    {
        return $this->belongsTo('App\Model\contact\contact');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
