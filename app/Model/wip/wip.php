<?php

namespace App\Model\wip;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class wip extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    protected $guarded = [];
    protected $auditExclude = [
        'tenant_id',
        'company_id',
        'status'
    ];
    protected $casts = [
        'result_qty' => 'float',
    ];

    public function wip_item()
    {
        return $this->hasMany('App\Model\wip\wip_item');
    }

    public function spk_item()
    {
        return $this->hasMany('App\Model\spk\spk_item');
    }

    public function spk()
    {
        return $this->belongsTo('App\Model\spk\spk', 'selected_spk_id');
    }

    public function contact()
    {
        return $this->belongsTo('App\Model\contact\contact', 'contact_id');
    }

    public function product()
    {
        return $this->belongsTo('App\Model\product\product', 'result_product');
    }

    public function other_transaction()
    {
        return $this->belongsTo('App\Model\other\other_transaction');
    }

    public function warehouse()
    {
        return $this->belongsTo('App\Model\warehouse\warehouse');
    }

    public function status()
    {
        return $this->belongsTo('App\Model\other\other_status', 'status');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
