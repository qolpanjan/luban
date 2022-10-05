<?php

namespace app\lib\exception;

class CategoryMissException extends BaseException
{
    public $code = 404;

    public $mgs = '目录不存在,请检查参数';

    public $errCode = 50000;
}