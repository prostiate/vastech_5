<?php

namespace App\Model\purchase;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class purchase_quote extends Model implements Auditable
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

    public function purchase_quote_item()
    {
        return $this->hasMany('App\Model\purchase\purchase_quote_item');
    }     
    
    public function transaction()
    {
        return $this->belongsTo('App\Model\other\other_transaction');
    } 

    public function contact()
    {
        return $this->belongsTo('App\Model\contact\contact');
    }

    public function term()
    {
        return $this->belongsTo('App\Model\other\other_term');
    }

    public function warehouse()
    {
        return $this->belongsTo('App\Model\warehouse\warehouse');
    }

    public function product()
    {
        return $this->belongsTo('App\Model\product\product');
    }

    public function status()
    {
        return $this->belongsTo('App\Model\other\other_status', 'status');
    }
}
