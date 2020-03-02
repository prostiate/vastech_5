<?php

namespace App\Model\company;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class company extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    protected $guarded = [];
    protected $auditExclude = [
        'tenant_id',
    ];

    public function tenant()
    {
        return $this->belongsTo('App\tenant');
    }

    public function user()
    {
        return $this->hasMany('App\User');
    }
}
