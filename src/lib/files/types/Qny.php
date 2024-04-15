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

    /**
     * 单个上传
     * @param $validateType
     * @param $disk
     * @return void
     */
    public function uploadSingle($validateType = ['file' => 'fileSize:1024000|fileExt:jpg,png,p12'], $disk = 'qny')
    {


    }


    /**
     * @param $callbackUrl token生成
     * @return string
     * @throws Error
     */
    public function buildToken($callbackUrl = "", $attr = [])
    {
        $attr = json_encode($attr, JSON_UNESCAPED_UNICODE);
        if (!isset($this->config['ak'])) throw new Error('ak不能为空');
        if (!isset($this->config['sk'])) throw new Error('sk不能为空');
        if (!isset($this->config['bucket'])) throw new Error('bucket不能为空');
        $cachePre = 'upload_qniuyun_';
        $config = Redis::get($cachePre);
        if ($config) return $config;
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
        $token = $auth->uploadToken($this->config['bucket'], null, $this->config['expire_time'] ?? 3600, $policy, true);
        $config = [
            'token' => $token,
            'bucket' => $this->config['bucket'],
            'upload_url' => $this->config['upload_url']
        ];
        Redis::set($cachePre, $config, $this->config['expire_time']);
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