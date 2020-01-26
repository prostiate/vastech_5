<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class journal_entry_item extends Model
{
    //protected $primaryKey = ['id', 'ref_id'];
    use SoftDeletes;
    protected $guarded = [];
    protected $table = "journal_entry_items";

    public function journal_entry()
    {
        return $this->belongsTo('App\journal_entry', 'journal_entry_id');
    }

    public function coa()
    {
        return $this->belongsTo('App\coa');
    }
}
