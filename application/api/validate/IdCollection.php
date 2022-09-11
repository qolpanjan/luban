<?php

namespace app\api\validate;

class IdCollection extends BaseValidate
{
    protected $rule = [
        'ids' => 'require|isIDsPostiveIntiger'
    ];

    protected $message = [
        'ids' => 'ids参数必须为以逗号分割的多个大于零的整数'
    ];

    protected function isIDsPostiveIntiger($value) {
        $values = explode(',', $value);

        if(empty($values)) {
            return false;
        }
        foreach($values as $id){
            if(!$this->isPositiveInteger($id)){
                return false;
            }
        }

        return true;
    }
}