<?php

namespace App\Model\sales;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class sale_return extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    protected $guarded = [];
    protected $auditExclude = [
        'tenant_id',
        'company_id',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo('App\user');
    }

    public function sale_return_item()
    {
        return $this->hasMany('App\Model\sales\sale_return_item');
    }

    public function sale_invoice()
    {
        return $this->belongsTo('App\Model\sales\sale_invoice', 'selected_si_id');
    }

    public function contact()
    {
        return $this->belongsTo('App\Model\contact\contact');
    }

    public function warehouse()
    {
        return $this->belongsTo('App\Model\warehouse\warehouse');
    }

    public function transaction()
    {
        return $this->belongsTo('App\Model\other\other_transaction');
    }

    public function status()
    {
        return $this->belongsTo('App\Model\other\other_status', 'status');
    }
}
