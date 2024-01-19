<?php

namespace Gz\Tp6Common\exception;


use think\exception\HttpException;

/**
 *  error错误类抛出
 *  editor: gz,
 *  motto: 大自然的搬运工
 *  time: 2024-01-13
 */
class Error extends \Exception
{

    public function __construct($message = "", $code = 200, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}