<?php

namespace App\Model\production;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class production_three extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    protected $guarded = [];
    protected $auditExclude = [
        'tenant_id',
        'company_id',
        'status'
    ];

    public function contact()
    {
        return $this->belongsTo('App\Model\contact\contact', 'contact_id');
    }

    public function other_transaction()
    {
        return $this->belongsTo('App\Model\other\other_transaction');
    }

    public function warehouse()
    {
        return $this->belongsTo('App\Model\warehouse\warehouse');
    }

    public function status()
    {
        return $this->belongsTo('App\Model\other\other_status', 'status');
    }

    public function unit()
    {
        return $this->belongsTo('App\Model\other\other_unit');
    }

    public function product()
    {
        return $this->belongsTo('App\Model\product\product');
    }

    public function production_three_item()
    {
        return $this->hasMany('App\Model\production\production_three_item');
    }
}
