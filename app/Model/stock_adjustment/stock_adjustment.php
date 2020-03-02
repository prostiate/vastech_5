<?php

namespace App\Model\stock_adjustment;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class stock_adjustment extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    protected $guarded = [];
    protected $auditExclude = [
        'tenant_id',
        'company_id',
    ];

    public function stock_adjustment_detail()
    {
        return $this->hasMany('App\Model\stock_adjustment\stock_adjustment_detail');
    }

    public function transaction()
    {
        return $this->belongsTo('App\Model\other\other_transaction');
    }

    public function coa()
    {
        return $this->belongsTo('App\Model\coa\coa');
    }

    public function warehouse()
    {
        return $this->belongsTo('App\Model\warehouse\warehouse');
    }
}
