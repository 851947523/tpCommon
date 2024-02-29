<?php

namespace Gz\TpCommon\lib\files\types;

use think\facade\Config;

/**
 *  本地上传
 *  editor: gz,
 *  motto: 大自然的搬运工
 *  time: 2024-02-18
 */
class Local extends Base
{
    public function uploadSingle()
    {
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file($this->filename);
        if (!$file) return;
        // 上传到本地服务器
        $savename = \think\facade\Filesystem::putFile('upload/' . $this->bucket, $file);
        return '/' . $savename;
    }

    public function uploadMore()
    {

    }

}