<?php
/*
 * @Author: alimzhan 15365185687@qq.com
 * @Date: 2022-08-28 17:11:25
 * @LastEditors: alimzhan 15365185687@qq.com
 * @LastEditTime: 2022-10-05 09:15:26
 * @FilePath: \think-5.0.7\application\api\validate\BaseValidate.php
 * @Description: 这是默认设置,请设置`customMade`, 打开koroFileHeader查看配置 进行设置: https://github.com/OBKoro1/koro1FileHeader/wiki/%E9%85%8D%E7%BD%AE
 */

namespace app\api\validate;

use app\lib\exception\ParameterException;
use app\lib\exception\BaseException;
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

    protected function isNotEmpty($value, $rule='', $data='', $field = '')
    {
        if (isEmpty($rule)) {
            return false;
        }else{
            return true;
        }
    }

    public function getDataByRule($arrays)
    {
        // 不允许包含user_id或者uid，防止恶意请求
        if (array_key_exists('user_id', $arrays) | array_key_exists('uid', $arrays)) {
            throw new ParameterException([
                'msg' => '不允许包含非法参数名user_id或者uid'
            ]);
        }
        $newArray = [];

        foreach($this->rule as $key => $value) {
            $newArray[$key] = $arrays[$key];
        }
        return $newArray;
    }
}