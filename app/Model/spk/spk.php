<?php

namespace App\Model\spk;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class spk extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    protected $guarded = [];
    protected $auditExclude = [
        'tenant_id',
        'company_id',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo('App\user');
    }

    public function spk_item()
    {
        return $this->hasMany('App\Model\spk\spk_item');
    }

    public function contact()
    {
        return $this->belongsTo('App\Model\contact\contact', 'contact_id');
    }

    public function other_transaction()
    {
        return $this->belongsTo('App\Model\other\other_transaction');
    }

    public function warehouse()
    {
        return $this->belongsTo('App\Model\warehouse\warehouse');
    }

    public function spk_status()
    {
        return $this->belongsTo('App\Model\other\other_status', 'status');
    }
}
