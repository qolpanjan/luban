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
}