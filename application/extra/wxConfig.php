<?php
/*
 * @Author: alimzhan 15365185687@qq.com
 * @Date: 2022-10-02 11:04:17
 * @LastEditors: alimzhan 15365185687@qq.com
 * @LastEditTime: 2022-10-02 16:52:25
 * @FilePath: \think-5.0.7\application\extra\wxConfig.php
 * @Description: 这是默认设置,请设置`customMade`, 打开koroFileHeader查看配置 进行设置: https://github.com/OBKoro1/koro1FileHeader/wiki/%E9%85%8D%E7%BD%AE
 */

 return [
    'app_id' => 'wx8dcf1a776813ab72',
    'app_secret' => '8a2a7fbfc0ff66074564b9ad8961af68',
    'login_url' => 'https://api.weixin.qq.com/sns/jscode2session?'.
        'appid=%s&secret=%s&js_code=%s&grant_type=authorization_code',
 ];