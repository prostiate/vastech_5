<?php

namespace App\Model\purchase;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class purchase_order extends Model implements Auditable
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

    public function purchase_order_item()
    {
        return $this->hasMany('App\Model\purchase\purchase_order_item');
    }

    public function purchase_delivery()
    {
        return $this->hasMany('App\Model\purchase\purchase_delivery');
    }

    public function transaction()
    {
        return $this->belongsTo('App\Model\other\other_transaction');
    }

    public function status()
    {
        return $this->belongsTo('App\Model\other\other_status', 'status');
    }

    public function contact()
    {
        return $this->belongsTo('App\Model\contact\contact');
    }

    public function term()
    {
        return $this->belongsTo('App\Model\other\other_term', 'term_id');
    }

    public function warehouse()
    {
        return $this->belongsTo('App\Model\warehouse\warehouse');
    }

    public function product()
    {
        return $this->belongsTo('App\Model\product\product');
    }

    public function purchase_quote()
    {
        return $this->belongsTo('App\Model\purchase\purchase_quote', 'selected_pq_id');
    }
}
