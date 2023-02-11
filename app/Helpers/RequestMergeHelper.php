<?php

namespace App\Helpers;

class RequestMergeHelper
{
    /**
     * @param $bearrer
     * @param $refresh
     * @return void
     */
    public function handle($bearrer, $refresh): void
    {
        request()->merge([
            'bearrer' => $bearrer,
            'refresh' => $refresh,
        ]);
    }
}
