<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class sale_invoice extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function sale_invoice_item()
    {
        return $this->hasMany('App\sale_invoice_item');
    }
    
    public function sale_order()
    {
        return $this->belongsTo('App\sale_order', 'selected_so_id');
    }

    public function sale_delivery()
    {
        return $this->belongsTo('App\sale_delivery', 'selected_sd_id');
    }

    public function sale_spk()
    {
        return $this->belongsTo('App\spk', 'selected_spk_id');
    }

    public function transaction()
    {
        return $this->belongsTo('App\other_transaction');
    }

    public function contact()
    {
        return $this->belongsTo('App\contact');
    }

    public function contact_marketting()
    {
        return $this->belongsTo('App\contact', 'marketting');
    }

    public function term()
    {
        return $this->belongsTo('App\other_term');
    }

    public function warehouse()
    {
        return $this->belongsTo('App\warehouse');
    }

    public function product()
    {
        return $this->belongsTo('App\product');
    }

    public function status()
    {
        return $this->belongsTo('App\other_status', 'status');
    }
}
