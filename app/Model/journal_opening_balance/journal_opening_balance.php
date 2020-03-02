<?php

namespace App\Model\journal_opening_balance;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class journal_opening_balance extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    protected $guarded = [];
    protected $auditExclude = [
        'tenant_id',
        'company_id',
    ];
    protected $table = "journal_opening_balances";

    public function journal_opening_balance_item()
    {
        return $this->hasMany('App\Model\journal_opening_balance\journal_opening_balance_item');
    }
    
    public function asset()
    {
        return $this->hasMany('App\Model\asset\asset');
    }
    
    public function status()
    {
        return $this->belongsTo('App\Model\other\other_status', 'status');
    }

    public function other_transaction()
    {
        return $this->belongsTo('App\Model\other\other_transaction');
    }

}
