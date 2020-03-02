<?php

namespace App\Model\cashbank;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class cashbank extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    protected $guarded = [];
    protected $auditExclude = [
        'tenant_id',
        'company_id',
        'status'
    ];

    public function cashbank_item()
    {
        return $this->hasMany('App\Model\cashbank\cashbank_item');
    }

    public function coa_pay_from()
    {
        return $this->belongsTo('App\Model\coa\coa', 'pay_from');
    }

    public function coa_transfer_from()
    {
        return $this->belongsTo('App\Model\coa\coa', 'transfer_from');
    }

    public function coa_deposit_to()
    {
        return $this->belongsTo('App\Model\coa\coa', 'deposit_to');
    }

    public function other_transaction()
    {
        return $this->belongsTo('App\Model\other\other_transaction', 'other_transaction_id');
    }

    public function status()
    {
        return $this->belongsTo('App\Model\other\other_status', 'status');
    }

    public function contact()
    {
        return $this->belongsTo('App\Model\contact\contact');
    }
}
