<?php

namespace app\api\validate;

class IdMustBePositiveInt extends BaseValidate
{
    protected $rule = [
        'id' => 'require|isPositiveInteger'
    ];

    protected $message =[
        'id' =>'id必须是大于零的整数，请检查'
    ];

    /**
     * @param $value 验证参数的值
     * @param $rule
     * @param $data 需要验证的参数键值对
     * @param $field 验证参数的键
     * @return 验证是否通过
     */
    protected function isPositiveInteger($value, $rule='', $data='', $field = '')
    {
        if(is_numeric($value) && is_int($value + 0) && ($value + 0) > 0) {
            return true;
        }else{
            return $field.'必须是大于零的整数，请检查';
        }
    }
}