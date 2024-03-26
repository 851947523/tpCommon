<?php

namespace Gz\TpCommon\lib\wchat;

use EasyWeChat\Kernel\Contracts\Server as ServerInterface;
use EasyWeChat\MiniApp\Server;
use Gz\TpCommon\lib\wchat\base\Config;
use Gz\TpCommon\lib\wchat\notify\Message;
use Gz\TpCommon\lib\wchat\notify\Notify;
use Gz\TpCommon\lib\wchat\notify\Pay;
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
    use Notify;

    public $app;
    public function __construct($config = [], $type = 'OpenPlatform')
    {
        $this->setConfig($config);
        $this->app = $this->switchNameSpace($type);
    }

}