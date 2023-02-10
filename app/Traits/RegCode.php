<?php

namespace App\Traits;

/**
 *
 */
trait RegCode
{
    /**
     * @return void
     */
    public static function booted(): void
    {
        static::creating(function ($model) {
            $model->reg_code = self::$reg_code;
        });
    }

}
