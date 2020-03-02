<?php

namespace App\Model\asset;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class asset_detail extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    protected $guarded = [];
    protected $auditExclude = [
        'tenant_id',
        'company_id'
    ];

    public function asset()
    {
        return $this->belongsTo('App\Model\asset\asset');
    }

    public function coa_depreciate_account()
    {
        return $this->belongsTo('App\Model\coa\coa','depreciate_account');
    } 
}
