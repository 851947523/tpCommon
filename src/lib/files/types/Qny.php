<?php

namespace Gz\TpCommon\lib\files\types;


use app\common\business\common\MerchantCustomerGalleryBusiness;
use Gz\TpCommon\exception\Error;
use Gz\TpCommon\lib\redis\Redis;
use Gz\TpCommon\utils\Ajax;
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;

/**
 *  七牛云上传
 *  editor: gz,
 *  motto: 大自然的搬运工
 *  time: 2024-02-18
 */
class Qny extends Base
{
    public $config = [
        'ak' => '',  //accessKey
        'sk' => '',  //secretKey
        //完成文件路径
        'filePath' => ''
    ];
    public $tempToken; //临时token
    public $auth;  //auth

    /**
     * 生成临时token,多图使用
     * @return void
     */
    private function buildTempToken()
    {
        if (empty($this->tempToken)) {
            $this->auth = new Auth($this->config['ak'], $this->config['sk']);

        }
        return $this;
    }

    /**
     * 单个上传
     * @param $validateType
     * @param $disk
     * @return void
     */
    public function uploadSingle($validateType = ['file' => 'fileSize:1024000|fileExt:jpg,png,p12'], $disk = 'qny')
    {
        $uploadMgr = new UploadManager();
        $expires = 3600;
        $this->buildTempToken();
        $bucket = $this->config['bucket'];
        $key = $this->config['key'] ?? uniqid().time();
        $token = $this->auth->uploadToken($this->config['bucket'],$key);
        $this->tempToken = $token;

        list($ret, $err) = $uploadMgr->putFile($this->tempToken,$key, $this->config['filePath']);
        if ($err) {
            return [
                'code' => 0,
                'msg' => $err,
            ];
        } else {
            return [
                'code' => 1,
                'msg' => 'ok',
                'hash' => $ret['hash'],
                'key' => $ret['key'],
            ];
        }
    }


    /**
     * @param $callbackUrl token生成
     * @return string
     * @throws Error
     */
    public function buildToken($callbackUrl = "", $attr = [])
    {
        if (!isset($this->config['ak'])) throw new Error('ak不能为空');
        if (!isset($this->config['sk'])) throw new Error('sk不能为空');
        if (!isset($this->config['bucket'])) throw new Error('bucket不能为空');
        $cachePre = 'upload_qniuyun_';
        $policy = [];
        if (!empty($callbackUrl)) {
            $policy = [
                'callbackUrl' => $callbackUrl,
                'callbackBody' => json_encode([
                    'key' => '$(key)',
                    'hash' => '$(hash)',
                    'fsize' => '$(fsize)',
                    'attr' => '$(x:attr)', //自定义值=> 前端参数需要x:merchant_id = 2
                    'ext' => '$(x:ext)',  //自定义值=> 前端参数需要x:merchant_id = 2
                    'merchant_id' => "$(x:merchant_id)", //自定义值=> 前端参数需要x:merchant_id = 2
                ], JSON_UNESCAPED_UNICODE)
            ];
        }
        $auth = new Auth($this->config['ak'], $this->config['sk']);
        $token = $auth->uploadToken($this->config['bucket'], null, 3600, $policy, true);
        $config = [
            'token' => $token,
            'bucket' => $this->config['bucket'],
            'upload_url' => $this->config['upload_url'],
            'host' => $this->config['host'] ?? '',
        ];
        return $config;
    }


    /**
     * 直传 回调处理,七牛云回调处理
     * @return void
     */
    public function handleNotify()
    {
        //回调处理
        //存储消息
        $param = file_get_contents('php://input');
        $param = json_decode($param, true);
        try {
            $data = [
                'path' => $param['key'],
                'hash' => $param['hash'],
                'size' => $param['fsize'],
                'type' => 'qniuyun',
                'merchant_id' => $param['merchant_id'],
            ];
            $result = MerchantCustomerGalleryBusiness::instance()->save($data);
            return Ajax::success(lang('success'), $param);
        } catch (Exception $e) {
            file_put_contents('error.txt', $e->getMessage());
            return Ajax::success('上传错误');
        }
    }

    /**
     * 删除七牛云
     */
//    public function delete()
//    {
//
//    }

    /**
     * 字节上传
     * @return void
     */
//    private function uploadByte($file)
//    {
//        $auth = new Auth($this->config['ak'], $this->config['sk']);
//        $token = $auth->uploadToken($this->config['bucket']);
//
//    }


//    public function uploadMore()
//    {
//
//    }

}