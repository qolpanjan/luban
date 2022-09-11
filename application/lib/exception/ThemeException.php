<?php

namespace app\lib\exception;

class ThemeException extends BaseException
{
    public $code = 404;

    public $mgs = '请求的主题不存在';

    public $errCode = 30000;
}