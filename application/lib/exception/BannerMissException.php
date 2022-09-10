<?php

namespace app\lib\exception;

class BannerMissException extends BaseException
{
    public $code = 404;

    public $mgs = '请求的轮播图不存在';

    public $errCode = 40000;
}