<?php

namespace App\Traits;

/**
 *
 */
trait RegCodeTrait
{
    /**
     * @return void
     */
    public static function booted(): void
    {
        static::creating(function ($model) {
            $last_id = self::query()->max("id") + 1;
            $model->reg_code = self::$reg_code . str_repeat("0", (4 - strlen($last_id))) . $last_id;
        });
    }

}
