<?php
/*
 * @Author: alimzhan 15365185687@qq.com
 * @Date: 2022-10-05 21:51:54
 * @LastEditors: alimzhan 15365185687@qq.com
 * @LastEditTime: 2022-10-06 18:56:37
 * @FilePath: \think-5.0.7\application\api\model\Order.php
 * @Description: 这是默认设置,请设置`customMade`, 打开koroFileHeader查看配置 进行设置: https://github.com/OBKoro1/koro1FileHeader/wiki/%E9%85%8D%E7%BD%AE 
 */
namespace app\api\model;

class Order extends BaseModel
{
    protected $hidden = ['user_id', 'delete_time', 'update_time'];
    protected $autoWriteTimestamp = true;

    protected static function getSummaryByUser($uid, $page = 1, $size =15)
    {
        $summary = self::where('user_id', '=',$uid)
            ->order('create_time desc')
            ->paginate($size, true, ['page' => $page]);
        return $summary;
    }

}