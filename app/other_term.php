<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class other_term extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    
    public function purchase_invoice()
    {
        return $this->hasMany('App\purchase_invoice', 'term_id');
    }

    public function purchase_order()
    {
        return $this->hasMany('App\purchase_order', 'term_id');
    }

    public function purchase_quote()
    {
        return $this->hasMany('App\purchase_quote', 'term_id');
    }

    public function sale_invoice()
    {
        return $this->hasMany('App\sale_invoice', 'term_id');
    }

    public function sale_order()
    {
        return $this->hasMany('App\sale_order', 'term_id');
    }

    public function sale_quote()
    {
        return $this->hasMany('App\sale_quote', 'term_id');
    }

    public function cashbank()
    {
        return $this->hasMany('App\cashbank', 'term_id');
    }

    public function contact()
    {
        return $this->hasMany('App\contact', 'term_id');
    }

    public function expense()
    {
        return $this->hasMany('App\expense', 'term_id');
    }
}
