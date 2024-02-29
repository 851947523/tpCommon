<?php

namespace Gz\TpCommon\consts;

use Gz\TpCommon\consts\interfaces\StatusInterface;
use think\facade\Config;
use think\facade\Lang;

/**
 * @mixin StatusInterface
 */
class Status
{
    static $codeDefault = 0; //默认
    static $codeSuc = 1; //通过操作成功
    static $suc = 'success';
    static $err = 'error';

    public static function __callStatic($method, $argument)
    {

        $default_lang = Config::get('lang.default_lang');
        $file = __DIR__ . '/lang/' . $default_lang . '.php';
        if(file_exists($file)){

            $arr = require_once __DIR__ . '/lang/' . $default_lang . '.php';
            if (isset($arr[$method])) {
                return $arr[$method];
            }
        }
        $msg = Lang::get($method);
        return $msg ? $msg : 'msg not exists';
    }
}