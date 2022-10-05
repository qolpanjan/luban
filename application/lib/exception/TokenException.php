<?php
/*
 * @Author: alimzhan 15365185687@qq.com
 * @Date: 2022-10-02 15:15:02
 * @LastEditors: alimzhan 15365185687@qq.com
 * @LastEditTime: 2022-10-02 15:15:06
 * @FilePath: \think-5.0.7\application\lib\exception\TokenException.php
 * @Description: 这是默认设置,请设置`customMade`, 打开koroFileHeader查看配置 进行设置: https://github.com/OBKoro1/koro1FileHeader/wiki/%E9%85%8D%E7%BD%AE
 */
class TokenException extends BaseException
{
    public $code = 401;
    public $msg = 'Token 已过期或无效token';
    public $errorCode = 100001;
}