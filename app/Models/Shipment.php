<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Shipment extends Model
{
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'user_id', 'date', 'Ref', 'sale_id', 'delivered_to', 'shipping_address', 'status', 'shipping_details',

    ];

    protected $casts = [
        'user_id' => 'integer',
        'sale_id' => 'integer',
    ];

    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
