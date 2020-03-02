<?php

namespace App\Model\coa;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class coa_detail extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    protected $guarded = [];
    protected $auditExclude = [
        'tenant_id',
        'company_id',
    ];

    public function coa()
    {
        return $this->belongsTo('App\Model\coa\coa');
    }

    public function sale_detail()
    {
        return $this->belongsTo('App\Model\sales\sale_detail');
    }

    public function contact()
    {
        return $this->belongsTo('App\Model\contact\contact');
    }

    public function other_transaction()
    {
        return $this->belongsTo('App\Model\other\other_transaction');
    }
}
