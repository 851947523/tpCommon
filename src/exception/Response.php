<?php

namespace Gz\TpCommon\exception;



use Gz\TpCommon\consts\Status;
use Gz\TpCommon\utils\Ajax;

use Gz\Utools\Instance\Instance;
use think\Response as TpResponse;
 
/**
 *  editor: gz,
 *  motto: 大自然的搬运工
 *  time: 2024-01-13
 */
class Response
{
    use Instance;

    public function send($message = "", $data = [], $code = 1)
    {
        $response['msg'] = empty($message) ? Status::$suc : $message;
        $response['data'] = $data ?? [];
        $response['code'] = $code ?? 1;
        $result = json_encode($response, JSON_UNESCAPED_UNICODE);
        return TpResponse::create($result)->send();
    }
}