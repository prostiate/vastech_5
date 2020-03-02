<?php

namespace App\Model\product;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class product_production_item extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    protected $guarded = [];
    protected $auditExclude = [
        'tenant_id',
        'company_id',
    ];
    protected $casts = ['qty' => 'float'];

    public function product()
    {
        return $this->belongsTo('App\Model\product\product');
    }

    public function bundle_product()
    {
        return $this->belongsTo('App\Model\product\product', 'bundle_product_id');
    }
}
