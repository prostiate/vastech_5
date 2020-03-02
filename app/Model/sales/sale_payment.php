<?php

namespace App\Model\sales;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class sale_payment extends Model implements Auditable
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

    public function sale_payment_item()
    {
        return $this->hasMany('App\Model\sales\sale_payment_item');
    }

    public function sale_invoice()
    {
        return $this->hasMany('App\Model\sales\sale_invoice', 'sale_invoice_id');
    }

    public function sale_invoice_id()
    {
        return $this->belongsTo('App\Model\sales\sale_invoice', 'transaction_no_si');
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
