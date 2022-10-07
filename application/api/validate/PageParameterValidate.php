<?php
/*
 * @Author: alimzhan 15365185687@qq.com
 * @Date: 2022-10-06 18:27:17
 * @LastEditors: alimzhan 15365185687@qq.com
 * @LastEditTime: 2022-10-06 18:28:23
 * @FilePath: \think-5.0.7\application\api\validate\PageParameterValidate.php
 * @Description: 这是默认设置,请设置`customMade`, 打开koroFileHeader查看配置 进行设置: https://github.com/OBKoro1/koro1FileHeader/wiki/%E9%85%8D%E7%BD%AE
 */
namespace app\api\validate;

class PageParameterValidate extends BaseValidate
{
    protected $rule = [
        'page' => 'require|isPositiveInteger',
        'size' => 'require|isPositiveInteger'
    ];

    protected $message = [
        'page' => '分页参数必须是大于零的整数',
        'size' => '分页参数必须是大于零的整数'
    ];
}
