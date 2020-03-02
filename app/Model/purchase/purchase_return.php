<?php

namespace App\Model\purchase;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class purchase_return extends Model implements Auditable
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

    public function purchase_return_item()
    {
        return $this->hasMany('App\Model\purchase\purchase_return_item');
    }

    public function purchase_invoice()
    {
        return $this->belongsTo('App\Model\purchase\purchase_invoice', 'selected_pi_id');
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
