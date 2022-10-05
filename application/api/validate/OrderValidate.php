<?php
/*
 * @Author: alimzhan 15365185687@qq.com
 * @Date: 2022-10-05 11:11:14
 * @LastEditors: alimzhan 15365185687@qq.com
 * @LastEditTime: 2022-10-05 11:20:39
 * @FilePath: \think-5.0.7\application\api\validate\ProductValidate.php
 * @Description: 这是默认设置,请设置`customMade`, 打开koroFileHeader查看配置 进行设置: https://github.com/OBKoro1/koro1FileHeader/wiki/%E9%85%8D%E7%BD%AE
 */
namespace app\api\validate;

class OrderValidate extends BaseValidate
{
    protected $rule = [
        'products' => 'checkProducts'
    ];

    protected $singleRule = [
        'count' => 'require|isPositiveInteger',
        'product_id' => 'require|isPositiveInteger'
    ];

    protected function checkProducts($values) {
        if (!is_array($values)) {
            throw new ParameterException([
                'msg' => '商品列表参数错误'
            ]);
        }

        if (!isEmpty($values)) {
            throw new ParameterException([
                'msg' => '商品列表为空'
            ]);
        }

        foreach($values as $value){
            $this->checkSingleProduct($value);
        }
        return true;
    }

    protected function checkProduct($value) {
        $validate = new BaseValidate($this->singleRule);
        $res = $validate->check($value);
        if (!res) {
            throw new ParameterException([
                'msg' => '商品列表参数错误'
            ]);
        }
    }
}