<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $guarded = [];

    protected $with = ['currency'];

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'default_currency_id', 'id');
    }
}
