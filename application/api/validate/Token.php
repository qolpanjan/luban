<?php
/*
 * @Author: alimzhan 15365185687@qq.com
 * @Date: 2022-10-02 10:37:42
 * @LastEditors: alimzhan 15365185687@qq.com
 * @LastEditTime: 2022-10-02 10:39:08
 * @FilePath: \think-5.0.7\application\api\validate\Token.php
 * @Description: 这是默认设置,请设置`customMade`, 打开koroFileHeader查看配置 进行设置: https://github.com/OBKoro1/koro1FileHeader/wiki/%E9%85%8D%E7%BD%AE
 */

namespace app\api\validate;

class Token extends BaseValidate
{
    protected $rule = [
        'code' => 'require|isNotEmpty'
    ];

    protected $message =[
        'code' => '请求code为空'
    ];
}