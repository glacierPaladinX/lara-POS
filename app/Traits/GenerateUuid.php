
<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;

trait GenerateUuid
{

    public static function bootGenerateUuid(): void
    {
        static::creating(function (Model $model) {

            if (Schema::hasColumn($model->getTable(), 'uuid')) {

                $model->uuid = Str::uuid()->toString();
            }
        });
    }
}