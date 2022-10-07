<?php
/*
 * @Author: alimzhan 15365185687@qq.com
 * @Date: 2022-10-06 13:35:46
 * @LastEditors: alimzhan 15365185687@qq.com
 * @LastEditTime: 2022-10-06 13:35:51
 * @FilePath: \think-5.0.7\application\lib\enum\OrderStatusEnum.php
 * @Description: 这是默认设置,请设置`customMade`, 打开koroFileHeader查看配置 进行设置: https://github.com/OBKoro1/koro1FileHeader/wiki/%E9%85%8D%E7%BD%AE
 */
namespace app\lib\enum;

class OrderStatusEnum
{
    //待支付
    const UNPAID = 1;

    //已支付
    const PAID = 2;

    // 已发货
    const DELIVERED = 3;

    //已支付但是库存不足
    const PAID_BUT_OUT_OF = 4;
}