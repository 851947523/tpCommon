<?php

namespace Gz\TpCommon\lib\wchat;

use Gz\TpCommon\lib\wchat\base\WchatBase;
use Gz\TpCommon\utils\Ajax;
use Gz\Utools\Instance\Instance;

/**
 *  editor: gz,
 *  motto: 大自然的搬运工
 *  time: 2024-03-12
 */
class Wchat extends WchatBase
{
    use Instance;

    public $app;

    public function __construct($config)
    {
        parent::__construct($config);
    }



}