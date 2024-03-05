<?php

namespace Gz\TpCommon\lib\redis;


use Gz\Utools\Instance\Instance;
use think\facade\Cache;

/**
 * @mixin \Redis;
 *  editor: gz,
 *  motto: 大自然的搬运工
 *  time: 2024-02-06
 */
class Redis
{
    use Instance;


    public static function __callStatic($name, $argument)
    {
        
        return Cache::store('redis')->$name(...$argument);
    }
}