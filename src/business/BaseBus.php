<?php

namespace Gz\TpCommon\business;

use Gz\TpCommon\classes\db\BaseQuery;


use Gz\Utools\Instance\Instance;
use think\db\Query;
use think\facade\Request;

/**
 *  editor: gz,
 *  motto: 大自然的搬运工
 *  time: 2024-01-13
 *  @mixin Query;
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
}