<?php

namespace Gz\TpCommon\business;

use Gz\TpCommon\classes\db\BaseQuery;


use Gz\TpCommon\lib\redis\Redis;
use Gz\Utools\Instance\Instance;

use Symfony\Component\VarExporter\Tests\Fixtures\LazyGhost\ChildStdClass;
use think\db\Query;
use think\facade\Request;

/**
 *  editor: gz,
 *  motto: 大自然的搬运工
 *  time: 2024-01-13
 * @mixin Query;
 */
abstract class BaseBus
{

    /**
     * 业务层
     * @var $bus
     */
    public $bus;
    /**
     *  数据层
     * datas
     */
    public $dataClass;

    public $methods;

    use Instance;
    use BaseQuery;

    /**
     * 参数
     * @var
     */
    protected $param;


    public function __construct()
    {
        $this->param = Request::param();
        $this->_init();
    }


    /**
     * 初始化
     * @return void
     */
    public function _init()
    {
        if (!empty($this->dataClass)) {
            $reflection = new \ReflectionClass($this->dataClass);
            foreach ($reflection->getMethods(\ReflectionMethod::IS_PUBLIC) as $method) {
                $methodName = $method->getName();
                $this->{$methodName} = \Closure::bind(function () use ($methodName) {
                    return call_user_func_array([$this->dataClass, $methodName], func_get_args());
                }, $this,$this);

            }
        }

    }


    /**
     *  单个赋值字段别名
     * @param $field_name
     * @param $alias
     * @return mixed|string
     */
    public function handleFieldByAlias($field_name = '', $alias = '')
    {
        $field = !empty($alias) ? $alias . '.' . $field_name : $field_name;
        return $field;
    }

    /**
     * 拼装searchr参数
     * @param $alias
     * @return array
     */
    public function handleSearchParam($alias, $attr = [])
    {
        return [
            'alias' => $alias,
            ...Request::param(),
            ...$attr
        ];
    }


    /**
     * 给多个字段加上别名
     */
    public function handleFieldsByAlias($fieldsArr, $alias = '')
    {
        $fieldsArr = is_array($fieldsArr) ? $fieldsArr : explode(',', $fieldsArr);
        return array_map(function ($item) use ($alias) {
            return $alias . '.'.$item;
        }, $fieldsArr);

    }

    /**
     * 获取search 别名参数组合。如果使用witchSearch 别名的话，用到
     * @return void
     */
    public function getSearchParam($alias,$attr = [])
    {
        return [
            'alias' => $alias,
            ...Request::param(),
            ...$attr
        ];
    }










}