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
    private $_model;

    public function __call($method, $args)
    {
        if (!isset($this->model) || empty($this->model)) {
            throw new Exception(Status::emptyModel());
        }
        $this->_model = call_user_func_array([$this->model, $method], $args);
        return $this;
    }

    public function end()
    {
        return $this->_model;
    }

    /**
     * 自动分页 针对api
     * @return array
     * @throws Exception
     */
    public function selectPage()
    {
        if (empty($this->_model)) {
            throw new Exception(Status::emptyModel());
        }
        try {
            //var_dump($this->_model);
            /** @var  \think\Model */
            $data['count'] = $this->_model->count();
            $model = $this->_model;
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

        if (empty($this->_model)) throw new Exception(Status::emptyModel());
        try {
            $model = $this->_model;
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
        $this->_model = $this->_model->withSearch($withSearch, $param);
        return $this;
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
