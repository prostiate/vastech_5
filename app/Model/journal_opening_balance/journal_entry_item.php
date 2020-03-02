<?php

namespace App\Model\journal_opening_balance;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class journal_entry_item extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    protected $guarded = [];
    protected $auditExclude = [
        'tenant_id',
        'company_id',
    ];

    public function journal_entry()
    {
        return $this->belongsTo('App\Model\journal_opening_balance\journal_entry', 'journal_entry_id');
    }

    public function coa()
    {
        return $this->belongsTo('App\Model\coa\coa');
    }
}
