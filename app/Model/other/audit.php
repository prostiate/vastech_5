<?php

namespace App\Model\other;

use Illuminate\Database\Eloquent\Model;

class audit extends Model
{
    protected $guarded = [];
    protected $casts = [
        'old_values'   => 'array',
        'new_values'   => 'array',
        'auditable_id' => 'integer',
    ];
    public function user()
    {
        return $this->belongsTo('App\user');
    }
}
