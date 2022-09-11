<?php

namespace app\api\validate;

use app\lib\exception\ParameterException;
use Couchbase\BaseException;
use think\Exception;
use think\Request;
use think\Validate;

class BaseValidate extends Validate
{
    /**
     * @throws ParameterException
     */
    public function goCheck()
    {
        // 获取http传入的参数
        // 对参数进行校验
        $request = Request::instance();
        $param = $request->param();
        $result = $this->batch()->check($param);

        if(!$result) {
            throw new ParameterException([
                'msg' => $this->error
            ]);
        }else{
            return true;
        }
    }

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
            return false;
        }
    }
}