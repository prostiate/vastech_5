<?php

namespace App\Model\expense;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class expense_item extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    protected $guarded = [];
    protected $auditExclude = [
        'tenant_id',
        'company_id'
    ];

    public function expense()
    {
        return $this->belongsTo('App\Model\expense\expense');
    }

    public function expense_id()
    {
        return $this->belongsTo('App\Model\expense\expense');
    }

    public function tax()
    {
        return $this->belongsTo('App\Model\other\other_tax');
    }

    public function coa()
    {
        return $this->belongsTo('App\Model\coa\coa');
    }
}
