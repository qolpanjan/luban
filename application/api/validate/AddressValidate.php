<?php
/*
 * @Author: alimzhan 15365185687@qq.com
 * @Date: 2022-10-02 17:58:35
 * @LastEditors: alimzhan 15365185687@qq.com
 * @LastEditTime: 2022-10-04 23:12:47
 * @FilePath: \think-5.0.7\application\api\validate\AddressValidate.php
 * @Description: 这是默认设置,请设置`customMade`, 打开koroFileHeader查看配置 进行设置: https://github.com/OBKoro1/koro1FileHeader/wiki/%E9%85%8D%E7%BD%AE
 */
namespace app\api\validate;

class AddressValidate extends BaseValidate
{
    protected $rule = [
        'name' => 'require|isNotEmpty',
        'mobile' => 'require|isMobile',
        'province' => 'require|isNotEmpty',
        'city' => 'require|isNotEmpty',
        'country' => 'require|isNotEmpty',
        'detail' => 'require|isNotEmpty'
    ];

}