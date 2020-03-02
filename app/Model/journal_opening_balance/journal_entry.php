<?php

namespace App\Model\journal_opening_balance;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class journal_entry extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    protected $guarded = [];
    protected $auditExclude = [
        'tenant_id',
        'company_id',
    ];

    public function journal_entry_item()
    {
        return $this->hasMany('App\Model\journal_opening_balance\journal_entry_item');
    }

    public function status()
    {
        return $this->belongsTo('App\Model\other\other_status', 'status');
    }

    public function other_transaction()
    {
        return $this->belongsTo('App\Model\other\other_transaction');
    }

    public function asset()
    {
        return $this->hasMany('App\Model\asset\asset');
    }
}
