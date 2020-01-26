<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class purchase_quote_item extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    protected $casts = [
        'qty' => 'float',
    ];

    public function purchase_quote()
    {
        return $this->belongsTo('App\purchase_quote');
    } 

    public function product()
    {
        return $this->belongsTo('App\product');
    } 

    public function unit()
    {
        return $this->belongsTo('App\other_unit');
    } 

    public function tax()
    {
        return $this->belongsTo('App\other_tax');
    } 

}
