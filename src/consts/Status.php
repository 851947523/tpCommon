<?php

namespace Gz\TpCommon\consts;

use Gz\TpCommon\consts\interfaces\StatusInterface;
use think\facade\Config;
use think\facade\Lang;
use think\facade\Request;

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

        $header_var = \think\facade\Request::header(config('lang.header_var'));
        $header_var = empty($header_var) ? think\facade\Config::get('lang.default_lang') : trim($header_var);
        $file = __DIR__ . '/lang/' . $header_var . '.php';
        if (file_exists($file)) {

            $arr = require_once __DIR__ . '/lang/' . $header_var . '.php';
            if (isset($arr[$method])) {
                return $arr[$method];
            }
        }
        $msg = Lang::get($method);
        return $msg ? $msg : 'msg not exists';
    }
}