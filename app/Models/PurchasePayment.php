<?php

namespace App\Models;

use App\Support\HasAdvancedFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

class PurchasePayment extends Model
{
    use HasAdvancedFilter;

    public $orderable = [
        'id',
        'purchase_id',
        'payment_method',
        'amount',
        'payment_date',
        'created_at',
        'updated_at',
    ];

    public $filterable = [
        'id',
        'purchase_id',
        'payment_method',
        'amount',
        'payment_date',
        'created_at',
        'updated_at',
    ];

    protected $guarded = [];

    public function purchase(): BelongsTo
    {
        return $this->belongsTo(Purchase::class, 'purchase_id', 'id');
    }

    public function setAmountAttribute($value)
    {
        $this->attributes['amount'] = $value * 100;
    }

    public function getAmountAttribute($value)
    {
        return $value / 100;
    }

    public function getDateAttribute($value)
    {
        return Carbon::parse($value)->format('d M, Y');
    }

    public function scopeByPurchase($query)
    {
        return $query->wherePurchaseId(request()->route('purchase_id'));
    }
}
