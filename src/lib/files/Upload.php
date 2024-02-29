<?php

namespace Gz\TpCommon\lib\files;

use Gz\TpCommon\lib\files\interfaces\UploadInterface;
use Gz\TpCommon\lib\files\types\Local;
use Gz\TpCommon\lib\files\types\Qny;
use Gz\Utools\Instance\Instance;

/**
 * @mixin Local;
 * @mixin Qny;
 */
class Upload
{

    use Instance;


    /**
     * @param $filename 文件名称
     * @param $bucket  空间名
     * @param $type  local:本地 Qny:七牛云
     * @return $this;
     */
    public function init($filename = 'file', $bucket = 'image', $type = '')
    {
        if ($type == '') $type = 'Local';
        $reflection = new \ReflectionClass("Gz\\TpCommon\\lib\\files\\types\\{$type}");
        if (!$reflection->isInstantiable()) { //如果不能被实例化
            return false;
        }
        // $className = $reflection->getName(); //获取类名
        $constructor = $reflection->getConstructor(); //获取构造函数
        $parameters = $constructor->getParameters(); //获取contruct参数,数组
        $params = [];
        $params['filename'] = $filename;
        $params['bucket'] = $bucket;
        if ($parameters) {
            foreach ($parameters as $k => $v) {
                $class = $v->getType();
                if ($class) {
                    $params[$k] = new $class->name();  //获取具体参数，比如依赖注入类  比如 request
                }
            }
            return $reflection->newInstanceArgs($params); //实例化类
        } else {
            return $reflection->newInstanceArgs($params);
        }

    }


}