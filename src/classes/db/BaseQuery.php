<?php
declare (strict_types=1);

namespace Gz\TpCommon\classes\db;

/**
 * @mixin Query;
 * @mixin Model;
 */

use Gz\TpCommon\consts\Status;
use think\db\Query;
use think\Exception;
use think\facade\Request;
use think\Model;

trait BaseQuery
{
    public $model;
    public $attrs;

    public function __call($method, $args)
    {
        if (!isset($this->model) || empty($this->model)) {
            throw new Exception(Status::emptyModel());
        }
        $this->model = call_user_func_array([$this->model, $method], $args);
        return $this;
    }

    /**
     * 自动分页 针对api
     * @return array
     * @throws Exception
     */
    public function selectPage($bool = false, $expire = 0, $tag = '')
    {
        if (empty($this->model)) {
            throw new Exception(Status::emptyModel());
        }
        try {
            //var_dump($this->model);
            /** @var  \think\Model */
            $data['count'] = $this->model->count();
            $model = $this->model;
            if ($bool) $model = $model->cache($bool, $expire, $tag);
            $data['data'] = $model
                ->order($this->attrs['order'] ?? '')
                ->page(input('current_page', 1, 'intval'), input('limit', 30, 'intval'))->select()->append($this->attrs['append'] ?? []);
            return $data;
        } catch (\Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function selectAll($bool = false, $expire = null, $tag = '')
    {

        if (empty($this->model)) throw new Exception(Status::emptyModel());
        try {
            $model = $this->model;
            if ($bool) {
                $model = $model->cache($bool, $expire, $tag);
            }
            $data = $model
                ->order($this->attrs['order'] ?? '')->select()->append($this->attrs['append'] ?? []);
            return $data;
        } catch (\Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function append($append = [])
    {
        $this->attrs['append'] = $append;
        return $this;
    }

    public function order($order)
    {
        $this->attrs['order'] = $order;
        return $this;
    }

    public function withSearch($withSearch, $param = [])
    {
        $param = empty($param) ? Request::param() : $param;
        $this->model = $this->model->withSearch($withSearch, $param);
        return $this;
    }

    public function handleFieldByAlias($field_name = '', $alias = '')
    {
        $field = !empty($alias) ? $alias . '.' . $field_name : $field_name;
        return $field;
    }

    /**
     * 给多个字段加上别名
     */
    public function handleFieldsByAlias($fieldsArr, $alias = '')
    {
        $fieldsArr = is_array($fieldsArr) ? $fieldsArr : explode(',', $fieldsArr);
        return array_map(function ($item) use ($alias) {
            return $alias . $item;
        }, $fieldsArr);

    }

    /**
     * @param $id
     * @param $attr
     * @return array|mixed
     */
    public function getById($id, $attr = [])
    {
        return $this->where("id", $id)
            ->field($attr['field'] ?? '*')
            ->find();
    }

    /**
     * @param $condition
     * @return array|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getDataByCondition($condition)
    {
        return $this->where($condition)->select();
    }
}
