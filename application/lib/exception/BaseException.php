<?php

namespace app\lib\exception;

use think\Exception;

class BaseException extends Exception
{
    // http状态码
    public $code = 400;

    // 错误具体信息
    public $mgs = '参数错误';

    // 自定义错误码
    public $errCode = 10000;

    /**
     * @throws Exception
     */
    public function __construct($params = [])
    {
        if(!is_array($params)) {
//            throw new Exception('参数必须是数组');
            return;
        }
        if(array_key_exists('code', $params)) {
            $this->code = $params['code'];
        }
        if(array_key_exists('msg', $params)) {
            $this->mgs = $params['msg'];
        }
        if(array_key_exists('errorCode', $params)) {
            $this->errCode = $params['errorCode'];
        }
    }
}