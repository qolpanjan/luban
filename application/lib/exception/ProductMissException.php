<?php

namespace app\lib\exception;

class ProductMissException extends BaseException
{
    public $code = 404;

    public $mgs = '请求的商品不存在，请检查';

    public $errCode = 20000;
}