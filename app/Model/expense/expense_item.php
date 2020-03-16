<?php

namespace App\Model\expense;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class expense_item extends Model implements 
{
    use SoftDeletes;
    protected $guarded = [];

    public function expense()
    {
        return $this->belongsTo('App\Model\expense\expense');
    }

    public function expense_id()
    {
        return $this->belongsTo('App\Model\expense\expense');
    }

    public function tax()
    {
        return $this->belongsTo('App\Model\other\other_tax');
    }

    public function coa()
    {
        return $this->belongsTo('App\Model\coa\coa');
    }
}
