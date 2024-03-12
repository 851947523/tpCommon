<?php

namespace Gz\TpCommon\lib\wchat;

use Gz\TpCommon\lib\wchat\base\Config;
use Gz\Utools\Instance\Instance;

/**
 *
 *  editor: gz,
 *  motto: 大自然的搬运工
 *  time: 2024-03-12
 */
class Wchat
{
    use Instance;
    use Config;

    public $app;

    public function __construct($config, $type)
    {
        $this->setConfig($config);
        $this->app = $this->switchNameSpace($type);
    }


//    public function __call($name, $args)
//    {
//        return call_user_func([$this, $name], ...$args);
//    }


}