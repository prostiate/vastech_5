<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class bank_transfer extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function coa_t()
    {
        return $this->belongsTo('App\coa','transfers_account_id');
    }

    public function coa_d()
    {
        return $this->belongsTo('App\coa','deposit_account_id');
    }

    
}
