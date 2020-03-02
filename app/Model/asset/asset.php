<?php

namespace App\Model\asset;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class asset extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    protected $guarded = [];
    protected $auditExclude = [
        'tenant_id',
        'company_id',
        'status'
    ];

    public function asset_detail()
    {
        return $this->hasMany('App\Model\asset\asset_detail');
    }

    public function coa()
    {
        return $this->belongsTo('App\Model\coa\coa','asset_account');
    }       

    public function journal_entry()
    {
        return $this->belongsTo('App\Model\journal_opening_balance\journal_entry');
    }

}
