<?php

namespace Gz\TpCommon\lib\wchat\notify;

use EasyWeChat\Kernel\Support\AesGcm;
use Gz\TpCommon\exception\Error;

/**
 *  editor: gz,
 *  motto: 大自然的搬运工
 *  time: 2024-03-26
 */
trait Notify
{


    /**
     * 微信支付解密回调
     * 处理支付回调
     * @param string $type
     * @param string $APIv3_KEY //$APIv3_KEY就是在商户平台后端设置是APIv3秘钥
     * @return void
     */
    public function handlePaid($type = 'v3', $APIv3_KEY = '')
    {
        // 获取微信回调的XML数据
        $xmlData = file_get_contents('php://input');
        if (empty($xmlData)) throw new Error('错误响应');
        if ($type == 'v3') {
            //需要解密获取$APIv3_KEY
            $result = $this->decryptWechatpayData($APIv3_KEY, $xmlData);
            return [
                'code' => 'SUCCESS',
                'message' => '',
                'data' => $result
            ];
        } else {
            // 解析XML数据为数组
            $data = simplexml_load_string($xmlData, 'SimpleXMLElement', LIBXML_NOCDATA);
            $data = json_decode(json_encode($data), true);
            // 验证签名（这里假设你已经有了验证签名的函数）
            if (!$this->verifySignature($data)) throw new Error('签名失败');
            $result = [
                'code' => 'SUCCESS',
                'message' => '',
                'data' => $data,
            ];
        }
        return $result;
    }


    /**
     * https://github.com/wechatpay-apiv3/wechatpay-php#%E5%9B%9E%E8%B0%83%E9%80%9A%E7%9F%A5
     * v3 解密
     * @param $data
     * @return void
     */
    function decryptWechatpayData($apiv3Key, $xmlData)
    {
//        $file = file_get_contents('payXml.txt');
//        $file = json_decode(json_decode($file, true), true);
        $inBodyArray = (array)json_decode($xmlData, true);
        ['resource' => [
            'ciphertext' => $ciphertext,
            'nonce' => $nonce,
            'associated_data' => $aad
        ]] = $inBodyArray;
        $inBodyResource = \WeChatPay\Crypto\AesGcm::decrypt($ciphertext, $apiv3Key, $nonce, $aad);
        $inBodyResourceArray = (array)json_decode($inBodyResource, true);
        return $inBodyResourceArray;
    }


}