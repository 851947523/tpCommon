<?php

namespace Gz\TpCommon\lib\wchat\base;

use EasyWeChat\Pay\Application;
use Gz\TpCommon\utils\Ajax;

/**
 * @mixin  \EasyWeChat\OfficialAccount\Application
 * @mixin  \EasyWeChat\Pay\Application
 * @mixin  \EasyWeChat\MiniApp\Application
 * @mixin  \EasyWeChat\OpenPlatform\Application
 * @mixin  \EasyWeChat\Work\Application
 * @mixin  \EasyWeChat\OpenWork\Application
 *  editor: gz,
 *  motto: 大自然的搬运工
 *  time: 2024-03-12
 */
trait Config
{

    private $config = [];

    public function setConfig($config)
    {
        $this->config = $config;
    }

    public function getConfig()
    {
        return $this->config;
    }

    public function switchNameSpace($type)
    {
        switch ($type) {
            case 'OfficialAccount':
                $namespace = 'EasyWeChat\OfficialAccount\Application';
                break;
            case 'Pay':
                $namespace = 'EasyWeChat\Pay\Application';
                break;
            case 'MiniApp':
                $namespace = 'EasyWeChat\MiniApp\Application';
                break;
            case 'OpenPlatform':
                $namespace = 'EasyWeChat\OpenPlatform\Application';
                break;
            case 'Work':
                $namespace = 'EasyWeChat\Work\Application';
                break;
            case 'OpenWork':
                $namespace = 'EasyWeChat\OpenWork\Application';
                break;

        }
        $classs = (new $namespace($this->getConfig()));
        return $classs;

    }
}