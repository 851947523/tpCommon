<?php

namespace Gz\TpCommon\lib\files\types;

use Gz\TpCommon\exception\Error;
use think\facade\Config;

/**
 *  本地上传
 *  editor: gz,
 *  motto: 大自然的搬运工
 *  time: 2024-02-18
 */
class Local extends Base
{
    public function uploadSingle($validateType = ['file'=>'fileSize:10240|fileExt:jpg,png'])
    {
        try {
            // 获取表单上传文件 例如上传了001.jpg
            $file = request()->file($this->filename);
            validate($validateType)->check([$this->filename=>$file]);
            if (!$file) return;
             // 上传到本地服务器
            $savename = \think\facade\Filesystem::putFile('upload/' . $this->bucket, $file);
            return [
                'path' => '/' . $savename,
                'ext' => $file->getOriginalExtension(),
                'hash' => $file->hash(),
                'file_name'=>$file->getOriginalName(),
            ];
        } catch (\think\exception\ValidateException $e) {
            throw new Error($e->getMessage());
        }

    }

    public function uploadMore()
    {

    }

}