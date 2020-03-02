<?php

namespace App\Model\cashbank;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class cashbank_item extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    protected $guarded = [];
    protected $auditExclude = [
        'tenant_id',
        'company_id',
    ];

    public function cashbank()
    {
        return $this->belongsTo('App\Model\cashbank\cashbank');
    }

    public function expense()
    {
        return $this->belongsTo('App\Model\expense\expense', 'expense_id');
    }

    public function tax()
    {
        return $this->belongsTo('App\Model\other\other_tax');
    }

    public function coa()
    {
        return $this->belongsTo('App\Model\coa\coa', 'receive_from');
    }
}
