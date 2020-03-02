<?php

namespace App\Model\expense;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class expense extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    protected $guarded = [];
    protected $auditExclude = [
        'tenant_id',
        'company_id',
        'status'
    ];

    public function expense_contact()
    {
        return $this->belongsTo('App\Model\contact\contact', 'contact_id');
    }

    public function expense_item()
    {
        return $this->hasMany('App\Model\expense\expense_item');
    }

    public function status()
    {
        return $this->belongsTo('App\Model\other\other_status', 'status');
    }

    public function expense_status()
    {
        return $this->belongsTo('App\Model\other\other_status', 'status');
    }

    public function coa()
    {
        return $this->belongsTo('App\Model\coa\coa', 'pay_from_coa_id');
    }

    public function payment_method()
    {
        return $this->belongsTo('App\Model\other\other_payment_method', 'payment_method_id');
    }

    public function term()
    {
        return $this->belongsTo('App\Model\other\other_term', 'term_id');
    }

    public function other_transaction()
    {
        return $this->belongsTo('App\Model\other\other_transaction');
    }
}
