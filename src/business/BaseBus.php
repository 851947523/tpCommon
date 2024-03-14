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

    public function getDetailById($id)
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
     * 设置缓存
     * @return void
     */
    public function setCacheAllPre($merchant_id, $pre)
    {

        $resultData = $this->model->where("merchant_id", $merchant_id)->select();
        $resultData = $resultData ? $resultData->toArray() : $resultData;
        $data = [];
        foreach ($resultData as $v) {
            $data[$v['id']] = $v;
        }
        Redis::set($pre, $data);
        return $data;
    }

    /**
     * 获取缓存
     * @param $merchant_id
     * @return false|mixed|\Redis|string|null
     * @throws \RedisException
     */
    public function getCacheAllPre($merchant_id, $pre = '')
    {

        if (empty($merchant_id) || empty($pre)) return false;
        $data = Redis::get($pre);
        if ($data) {
            return $data;
        }
        $data = $this->setCacheAllPre($merchant_id, $pre);
        return $data;

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
    public function saveData($data)
    {
        return $this->model->save($data);

    }

    /**
     * 更新
     * @return void
     */
    public function updateById($id, $data)
    {
        if (empty($merchant_id)) return false;
        $data['merchant_id'] = $merchant_id;
        $detail = $this->getDetailById($id);
        if (empty($detail)) return false;
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