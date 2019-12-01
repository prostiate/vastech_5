<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class journal_entry extends Model
{
    //protected $primaryKey = ['id', 'ref_id'];
    use SoftDeletes;
    protected $guarded = [];

    public function journal_entry_item()
    {
        return $this->hasMany('App\journal_entry_item');
    }

    public function status()
    {
        return $this->belongsTo('App\other_status', 'status');
    }

    public function other_transaction()
    {
        return $this->belongsTo('App\other_transaction');
    }
}
