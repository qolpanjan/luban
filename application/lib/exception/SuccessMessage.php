<?php
/*
 * @Author: alimzhan 15365185687@qq.com
 * @Date: 2022-10-05 09:02:54
 * @LastEditors: alimzhan 15365185687@qq.com
 * @LastEditTime: 2022-10-05 09:03:07
 * @FilePath: \think-5.0.7\application\lib\exception\SuccessMessage.php
 * @Description: 这是默认设置,请设置`customMade`, 打开koroFileHeader查看配置 进行设置: https://github.com/OBKoro1/koro1FileHeader/wiki/%E9%85%8D%E7%BD%AE
 */

namespace app\lib\Exception;

class SuccessMessage extends BaseException
{
    public $code = 201;
    public $msg = 'success';
    public $errorCode = 0;
}