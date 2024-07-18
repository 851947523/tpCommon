<?php

namespace Gz\TpCommon\lib\files\interfaces;

/**
 *
 */
abstract class UploadInterface
{


    /**
     * 初始化
     *
     * @param $type  Local,Qny
     * @return $this;
     */
    public function init($type = 'Local')
    {
    }


    /**
     * 上传单个文件
     * @return mixed
     */
    public function uploadSingle($attr = ['file' => 'fileSize:1024000|fileExt:xls,xlsx'])
    {
    }

    /**
     * 上传多个文件
     */
    public function uploadMore()
    {
    }


    /**
     * 设置配置
     *
     * @return $this;
     */
    public function setConfig($config)
    {
    }


    /**
     * 创建临时token七牛云使用
     * @return $this
     */
    public function buildToken()
    {
    }

}