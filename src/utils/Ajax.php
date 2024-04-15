<?php

namespace Gz\TpCommon\utils;

use Gz\TpCommon\consts\Status;

class Ajax
{
    /**
     * 成功返回
     * @param $msg
     * @param $data
     * @param $code
     * @return \think\response\Json
     */
    static function success($msg = 'success', $data = [], $httpCode = 200)
    {

        $result = ['code' => Status::$codeSuc, 'msg' => $msg];
        if ($data) {
            $result['data'] = $data;
        }


        return json($result, $httpCode);
    }

    /**
     * 错误返回
     * @param $msg
     * @param int $code
     * @return \think\response\Json
     */
    static function error($msg = 'error', int $code, $httpCode = 200, $header = [], $options = [])
    {

        return json([
            'code' => empty($code) ? Status::$codeDefault : $code,
            'msg' => $msg
        ], $httpCode, $header, $options);
    }
}
