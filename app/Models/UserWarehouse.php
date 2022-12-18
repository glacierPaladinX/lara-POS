<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserWarehouse extends Model
{
    protected $table = 'user_warehouse';

    protected $fillable = [
        'user_id', 'warehouse_id',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'warehouse_id' => 'integer',
    ];

    public function assignedWarehouses(): HasMany
    {
        return $this->hasMany(Warehouse::class, 'id', 'warehouse_id');
    }
}
