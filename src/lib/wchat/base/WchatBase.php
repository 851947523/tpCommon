<?php

namespace Gz\TpCommon\lib\wchat\base;

use Gz\TpCommon\utils\Ajax;
use EasyWeChat\OfficialAccount\Application;


/**
 * @mixin  Application;
 *  editor: gz,
 *  motto: 大自然的搬运工
 *  time: 2024-03-12
 */
class WchatBase
{
    private $application;

    public function __construct($config)
    {
        $this->setApplication(new Application($config));
    }

    public function getApplication()
    {
        return $this->application;
    }

    public function setApplication($application)
    {
        $this->application = $application;
    }


}