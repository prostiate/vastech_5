<?php

namespace App\Model\purchase;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class purchase_payment extends Model implements Auditable
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

    public function purchase_payment_item()
    {
        return $this->hasMany('App\Model\purchase\purchase_payment_item');
    }

    public function purchase_invoice()
    {
        return $this->hasMany('App\Model\purchase\purchase_invoice', 'purchase_invoice_id');
    }

    public function contact()
    {
        return $this->belongsTo('App\Model\contact\contact');
    }

    public function coa()
    {
        return $this->belongsTo('App\Model\coa\coa', 'account_id');
    }

    public function payment_method()
    {
        return $this->belongsTo('App\Model\other\other_payment_method', 'other_payment_method_id');
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
