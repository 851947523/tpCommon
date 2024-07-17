<?php

namespace Gz\TpCommon\business;

use Gz\TpCommon\classes\db\BaseQuery;


use Gz\TpCommon\lib\redis\Redis;
use Gz\Utools\Instance\Instance;
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
    }

    public function getById($id)
    {
        return $this->model->where([
            'id' => $id,
        ])->find();
    }


    /**
     * 获取search 别名参数组合。如果使用witchSearch 别名的话，用到
     * @return void
     */
    public function getSearchParam($alias)
    {
        return [
            'alias' => $alias,
            ...Request::param()
        ];
    }


    /**
     * @return void
     */
    public function getAllData($where)
    {
        $data = $this->where($where)->selectPage();
        return $data;
    }


    /**
     * 新增
     * @return void
     */
    public function save($data)
    {
        return $this->model->save($data);

    }

    /**
     * 更新
     * @return void
     */
    public function updateById($id, $data)
    {
        $detail = $this->getDetailById($id);
        if (empty($detail)) return false;
        $data = is_object($data) ? $data->toArray() : $data;
        $result = $this->model::update($data, [
            'id' => $id,
        ]);
        return $result->save();
    }

    /**
     * 删除
     * @return void
     */
    public function deleteById($id)
    {
        $detail = $this->getDetailById($id);
        if (empty($detail)) return false;
        return $this->model::destroy([
            'id' => $id,
        ]);
    }
}