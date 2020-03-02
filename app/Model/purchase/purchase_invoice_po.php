<?php

namespace App\Model\purchase;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class purchase_invoice_po extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    protected $guarded = [];
    protected $auditExclude = [
        'tenant_id',
        'company_id',
        'status'
    ];

    public function purchase_invoice()
    {
        return $this->belongsTo('App\Model\purchase\purchase_invoice');
    }

    public function purchase_order()
    {
        return $this->belongsTo('App\Model\purchase\purchase_order');
    }
}
