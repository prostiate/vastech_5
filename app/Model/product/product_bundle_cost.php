<?php

namespace App\Model\product;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class product_bundle_cost extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    protected $guarded = [];
    protected $auditExclude = [
        'tenant_id',
        'company_id',
    ];

    public function product()
    {
        return $this->belongsTo('App\Model\product\product');
    }

    public function coa()
    {
        return $this->belongsTo('App\Model\coa\coa');
    }
}
