<?php

namespace Gz\TpCommon\business;

use Gz\TpCommon\utils\Ajax;
use Gz\Utools\Instance\Instance;

/**
 *  editor: gz,
 *  motto: 大自然的搬运工
 *  time: 2024-03-13
 */
class ConfigBus
{
    /**
     * 获取默认配置
     */
    use Instance;

    public $preFix = '';
    public $table = 'config';

    /**
     * 获取默认配置
     * @param $en_name
     * @return mixed
     */
    public function getValueByEnname($prefix = '', $en_name = '', $key = '')
    {
        $this->preFix = $prefix;
        $table = $this->preFix . $this->table;
        //{key:xxx,value:xxxx}
        $value = \think\facade\Db::table($table)->where(['en_name' => $en_name])->value('value');
        $valueArr = is_string($value) ? json_decode($value, true) : $value;
        return $valueArr;
    }
}