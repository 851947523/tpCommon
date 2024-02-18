<?php

namespace Gz\TpCommon\lib\files\interfaces;

interface UploadInterface
{
    /**
     * 上传单个文件
     * @return mixed
     */
    public function uploadSingle();

    /**
     * 上传多个文件
     */
    public function uploadMore();

}