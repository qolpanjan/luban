<?php
/*
 * @Author: alimzhan 15365185687@qq.com
 * @Date: 2022-10-05 15:54:41
 * @LastEditors: alimzhan 15365185687@qq.com
 * @LastEditTime: 2022-10-05 15:55:56
 * @FilePath: \think-5.0.7\application\lib\exception\OrderExcepion.php
 * @Description: 这是默认设置,请设置`customMade`, 打开koroFileHeader查看配置 进行设置: https://github.com/OBKoro1/koro1FileHeader/wiki/%E9%85%8D%E7%BD%AEs
 */

namespace app\lib\exception;

class OrderExcepion extends BaseException
{
    public $code = 404;

    public $msg = '订单不存在';

    public $errorCode = 80000;
}