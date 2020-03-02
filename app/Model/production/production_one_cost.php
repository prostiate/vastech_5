<?php

namespace App\Model\production;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class production_one_cost extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function production_one()
    {
        return $this->belongsTo('App\Model\production\production_one');
    }

    public function coa()
    {
        return $this->belongsTo('App\Model\coa\coa');
    }
}
