<?php

namespace app\api\validate;

class Count extends BaseValidate
{
    protected $rule = [
        'count' => 'isPositiveInteger|between:1,15',
    ];

    protected $message =[
        'count' => 'count应该是1到15之间的整数'
    ];
}