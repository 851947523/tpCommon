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
    public $config = [
        'filename'=>'file', //上传文件参数名
        'bucket'=> 'image', //上传空间名
    ];


    /**
     * @param $attr ['config'=> ['name'=> '空间名称']]
     */
    public function __construct($attr = [])
    {


    }

    /**
     * @param $config
     * @return $this
     */
    public function setConfig($config){
        $config = array_merge($this->config,$config);
        $this->config = $config;
        return $this;
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