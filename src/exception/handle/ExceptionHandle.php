<?php
namespace Gz\TpCommon\exception\handle;


use Gz\TpCommon\exception\Error;
use Gz\TpCommon\utils\Ajax;
use think\exception\Handle;
use think\Response;
use Throwable;

/**
 *  editor: gz,
 *  motto: 大自然的搬运工
 *  time: 2024-01-13
 */
class ExceptionHandle extends Handle
{

    /**
     * Render an exception into an HTTP response.
     *
     * @access public
     * @param \think\Request $request
     * @param Throwable $e
     * @return Response
     */
    public function render($request, Throwable $e): Response
    {
        $code = $e->getCode() != 0 ? $e->getCode() : 200;

        // 添加自定义异常处理机制
        if ($e instanceof Error) {
            return Ajax::error($e->getMessage(), $code);
        }

        // 其他错误交给系统处理
        return parent::render($request, $e);
    }

}