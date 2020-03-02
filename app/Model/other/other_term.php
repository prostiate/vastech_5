<?php

namespace App\Model\other;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class other_term extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    protected $guarded = [];
    protected $auditExclude = [
        'tenant_id',
        'company_id',
        'status'
    ];
    
    public function purchase_invoice()
    {
        return $this->hasMany('App\Model\purchase\purchase_invoice', 'term_id');
    }

    public function purchase_order()
    {
        return $this->hasMany('App\Model\purchase\purchase_order', 'term_id');
    }

    public function purchase_quote()
    {
        return $this->hasMany('App\Model\purchase\purchase_quote', 'term_id');
    }

    public function sale_invoice()
    {
        return $this->hasMany('App\Model\sales\sale_invoice', 'term_id');
    }

    public function sale_order()
    {
        return $this->hasMany('App\Model\sales\sale_order', 'term_id');
    }

    public function sale_quote()
    {
        return $this->hasMany('App\Model\sales\sale_quote', 'term_id');
    }

    public function cashbank()
    {
        return $this->hasMany('App\Model\cashbank\cashbank', 'term_id');
    }

    public function contact()
    {
        return $this->hasMany('App\Model\contact\contact', 'term_id');
    }

    public function expense()
    {
        return $this->hasMany('App\Model\expense\expense', 'term_id');
    }
}
