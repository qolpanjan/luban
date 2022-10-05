<?php
/*
 * @Author: alimzhan 15365185687@qq.com
 * @Date: 2022-10-05 09:46:28
 * @LastEditors: alimzhan 15365185687@qq.com
 * @LastEditTime: 2022-10-05 10:07:34
 * @FilePath: \think-5.0.7\application\lib\exception\UnAuthorizedException.php
 * @Description: 这是默认设置,请设置`customMade`, 打开koroFileHeader查看配置 进行设置: https://github.com/OBKoro1/koro1FileHeader/wiki/%E9%85%8D%E7%BD%AE
 */
namespace app\lib\exception;

class UnAuthorizedException extends BaseException
{
    public $code = 403;
    public $msg = '用户没有权限';
    public $errorCode = 10001;
}