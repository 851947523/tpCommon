<?php

namespace Gz\TpCommon\lib\jwt;


use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Gz\TpCommon\consts\Status;
use Gz\TpCommon\exception\Error;
use Gz\Utools\Instance\Instance;
use think\Exception;


/**
 *  editor: gz,
 *  motto: 大自然的搬运工
 *  time: 2024-02-06
 */

/**
 * 后台自用
 */
class Encrypt
{

    use Instance;

    private $key = 'key_';

    /**
     * @param $data
     * @param $key
     * @param $headers
     * @return string
     */
    public function encode($data, $key = '', $headers = [])
    {
        $key = empty($key) ? $this->key : $key;
        $payload = [
            'iss' => $data['iss'] ?? request()->domain(),
            'aud' => $data['aud'] ?? request()->domain(),
            'iat' => $data['iat'] ?? time(),
            'nbf' => $data['nbf'] ?? time(),
            'exp' => $data['exp'] ?? time() + 3600,
            'data' => $data['data'] ?? []
        ];
        return (string)(JWT::encode($payload, $key, 'HS256', null, $headers));
    }

    public function decode($token, $key = '')
    {
        try {

        } catch (Exception $e) {
            throw new Error(lang('login_expire'));
        } catch (ExpiredException $e) {
            throw new Error(lang('login_expire'));
        }
        $key = empty($key) ? $this->key : $key;
        return JWT::decode($token, new Key($key, 'HS256'));
    }


}