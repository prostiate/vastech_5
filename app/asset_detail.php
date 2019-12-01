<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class asset_detail extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function asset()
    {
        return $this->belongsTo('App\asset');
    }

    public function coa_depreciate_account()
    {
        return $this->belongsTo('App\coa','depreciate_account');
    } 
}
