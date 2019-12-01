<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class asset extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function asset_detail()
    {
        return $this->hasMany('App\asset_detail');
    }

    public function coa()
    {
        return $this->belongsTo('App\coa','asset_account');
    }       

    public function other_transaction()
    {
        return $this->belongsTo('App\other_transaction');
    }

}
