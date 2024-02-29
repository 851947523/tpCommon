<?php

namespace Gz\TpCommon\lib\files\types;


use Gz\TpCommon\lib\files\interfaces\UploadInterface;

/**
 *  editor: gz,
 *  motto: 大自然的搬运工
 *  time: 2024-02-18
 */
class Base implements UploadInterface
{
    public $config = [];
    public $bucket = ''; //上传空间名路径
    public $filename = ""; //需要获取上传的文件名

    /**
     * @param $attr ['config'=> ['name'=> '空间名称']]
     */
    public function __construct($filename = '', $bucket = '', $attr = [])
    {
        $this->config = $attr['config'] ?? [];
        $this->filename = $filename;
        $this->bucket = $bucket;

    }

    public function uploadSingle()
    {

    }

    /**
     * 上传多个文件
     */
    public function uploadMore()
    {

    }

}