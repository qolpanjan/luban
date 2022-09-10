<?php

namespace app\lib\exception;

class ParameterException extends BaseException
{
    // http状态码
    public $code = 400;

    // 错误具体信息
    public $mgs = '参数错误';

    // 自定义错误码
    public $errCode = 10000;


}