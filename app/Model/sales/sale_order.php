<?php

namespace App\Model\sales;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class sale_order extends Model implements Auditable
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

    public function sale_order_item()
    {
        return $this->hasMany('App\Model\sales\sale_order_item');
    }

    public function sale_delivery()
    {
        return $this->hasMany('App\Model\sales\sale_delivery');
    }

    public function transaction()
    {
        return $this->belongsTo('App\Model\other\other_transaction');
    }

    public function contact()
    {
        return $this->belongsTo('App\Model\contact\contact');
    }

    public function contact_marketting()
    {
        return $this->belongsTo('App\Model\contact\contact', 'marketting');
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

    public function status_order()
    {
        return $this->belongsTo('App\Model\other\other_status', 'status');
    }

    public function sale_quote()
    {
        return $this->belongsTo('App\Model\sales\sale_quote', 'selected_sq_id');
    }
}
