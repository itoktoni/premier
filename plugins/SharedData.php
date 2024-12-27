<?php

namespace Plugins;

use Illuminate\Support\Facades\Cache;

class SharedData
{
    public static function get($key)
    {
        $userID = auth()->user()->id;
        $data = Cache::get($userID.'-'.$key) ?? null;

        return $data;
    }
}
