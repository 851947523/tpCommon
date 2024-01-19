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
    public function selectPage()
    {
        if (empty($this->model)) {
            throw new Exception(Status::emptyModel());
        }
        try {
            //var_dump($this->model);
            /** @var  \think\Model */
            $model = $this->model;
            if (isset($this->options['append'])) {
                $data['data'] = $model->select()->append($this->options['append']);
            } else {
                $data['data'] = $model->select();
            }
            $data['count'] = $this->model->count();
            return $data;
        } catch (\Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function append($append = [])
    {
        $this->options['append'] = $append;
        return $this;
    }

    public function withSearch($withSearch, $param = [])
    {
        $param = empty($param) ? Request::param() : $param;
        $this->model = $this->model->withSearch($withSearch, $param);
        return $this;
    }


//    public function update($args)
//    {
//        try {
//            $param = Request::param();
//            $model = $this->model->where('id', $param['id'])->find();
//            foreach ($param as $k => $v) {
//                $model->$k = $v;
//            }
//            $result = $model->save();
//            return $result ? Ajax::success(Status::$editSuc) : Ajax::error(Status::$editErr);
//        } catch (\Exception $e) {
//            throw new Error($e->getMessage());
//        }
//
//    }


}
