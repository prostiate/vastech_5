<?php

namespace App\Model\warehouse;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class warehouse_transfer extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    protected $guarded = [];
    protected $auditExclude = [
        'tenant_id',
        'company_id',
    ];

    public function from_warehouse()
    {
        return $this->belongsTo('App\Model\warehouse\warehouse', 'from_warehouse_id');
    }

    public function to_warehouse()
    {
        return $this->belongsTo('App\Model\warehouse\warehouse', 'to_warehouse_id');
    }

    public function other_transaction()
    {
        return $this->belongsTo('App\Model\other\other_transaction');
    }

    public function warehouse_transfer_item()
    {
        return $this->hasMany('App\Model\warehouse\warehouse_transfer_item');
    }
}
