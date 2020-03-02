<?php

namespace App\Model\contact;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class contact extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    protected $guarded = [];
    protected $auditExclude = [
        'tenant_id',
        'company_id',
    ];

    public function purchase_delivery()
    {
        return $this->hasMany('App\Model\purchase\purchase_delivery');
    }

    public function purchase_invoice()
    {
        return $this->hasMany('App\Model\purchase\purchase_invoice');
    }

    public function purchase_payment()
    {
        return $this->hasMany('App\Model\purchase\purchase_payment');
    }

    public function purchase_order()
    {
        return $this->hasMany('App\Model\purchase\purchase_order');
    }

    public function purchase_quote()
    {
        return $this->hasMany('App\Model\purchase\purchase_quote');
    }

    public function purchase_return()
    {
        return $this->hasMany('App\Model\purchase\purchase_return');
    }

    public function sale_delivery()
    {
        return $this->hasMany('App\Model\sales\sale_delivery');
    }

    public function sale_invoice()
    {
        return $this->hasMany('App\Model\sales\sale_invoice');
    }

    public function sale_payment()
    {
        return $this->hasMany('App\Model\sales\sale_payment');
    }

    public function sale_order()
    {
        return $this->hasMany('App\Model\sales\sale_order');
    }

    public function sale_quote()
    {
        return $this->hasMany('App\Model\sales\sale_quote');
    }

    public function sale_return()
    {
        return $this->hasMany('App\Model\sales\sale_return');
    }

    public function spk()
    {
        return $this->hasMany('App\Model\spk\spk');
    }

    public function wip()
    {
        return $this->hasMany('App\Model\wip\wip');
    }

    public function stock_adjustment()
    {
        return $this->hasMany('App\Model\stock_adjustment\stock_adjustment');
    }

    public function expense()
    {
        return $this->hasMany('App\Model\expense\expense');
    }

    public function cashbank()
    {
        return $this->hasMany('App\Model\cashbank\cashbank');
    }

    public function coa_detail()
    {
        return $this->hasMany('App\Model\coa\coa_detail');
    }

    public function other_transaction()
    {
        return $this->hasMany('App\Model\other\other_transaction');
    }

    public function coaPayable()
    {
        return $this->belongsTo('App\Model\coa\coa', 'account_payable_id');
    }

    public function coa_payable()
    {
        return $this->belongsTo('App\Model\coa\coa', 'account_payable_id');
    }

    public function coaReceivable()
    {
        return $this->belongsTo('App\Model\coa\coa', 'account_receivable_id');
    }

    public function term()
    {
        return $this->belongsTo('App\Model\other\other_term');
    }
}
