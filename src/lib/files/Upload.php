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
     * @param $options
     * @param $cache
     * @return UploadInterface
     * @throws \Exception
     */
    public static function instance($options = "",$cache = false)
    {
        $classFullName = self::getClassName();
        if (!$cache) {
            //清楚缓存
            if (isset(self::$instance[$classFullName])) {
                unset(self::$instance[$classFullName]);
            }
        }
        self::$options = $options;
        if (!isset(self::$instance[$classFullName]) && empty(self::$instance[$classFullName])) {
            if (!class_exists($classFullName, false)) {
                throw new \Exception('"' . $classFullName . '" was not found !');
            }
            $instance = self::$instance[$classFullName] = new static();
            return $instance;
        }
        return self::$instance[$classFullName];
    }


    /**
     * @param $filename 文件名称
     * @param $bucket  空间名
     * @param $type  local:本地 Qny:七牛云
     * @return UploadInterface
     */
    public function init($type = 'Local')
    {
        $reflection = new \ReflectionClass("Gz\\TpCommon\\lib\\files\\types\\{$type}");
        if (!$reflection->isInstantiable()) {
            return false;
        }
        // $className = $reflection->getName();
        $constructor = $reflection->getConstructor();
        $parameters = $constructor->getParameters();
        $params = [];
        if ($parameters) {
            foreach ($parameters as $k => $v) {
                $class = $v->getType();
                if ($class) {
                    $params[$k] = new $class->name();
                }
            }
            return $reflection->newInstanceArgs($params);
        } else {
            return $reflection->newInstanceArgs($params);
        }

    }


}