<?php
/*
 * @Author: alimzhan 15365185687@qq.com
 * @Date: 2022-10-02 10:53:11
 * @LastEditors: alimzhan 15365185687@qq.com
 * @LastEditTime: 2022-10-05 08:57:37
 * @FilePath: \think-5.0.7\application\api\model\User.php
 * @Description: 这是默认设置,请设置`customMade`, 打开koroFileHeader查看配置 进行设置: https://github.com/OBKoro1/koro1FileHeader/wiki/%E9%85%8D%E7%BD%AE
 */
namespace app\api\model\User;
class User extends BaseModel
{
    public function address()
    {
        return $this->hasOne('UserAddress', 'user_id', 'id');
    }

    public static function getUserByOpenID($openid)
    {
        return $user = self::where('openid', '=',$openid)->find();
    }


}
