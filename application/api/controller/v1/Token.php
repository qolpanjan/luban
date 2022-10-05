<?php
/*
 * @Author: alimzhan 15365185687@qq.com
 * @Date: 2022-10-02 10:28:43
 * @LastEditors: alimzhan 15365185687@qq.com
 * @LastEditTime: 2022-10-02 15:19:29
 * @FilePath: \think-5.0.7\application\api\controller\v1\Token.php
 * @Description: 这是默认设置,请设置`customMade`, 打开koroFileHeader查看配置 进行设置: https://github.com/OBKoro1/koro1FileHeader/wiki/%E9%85%8D%E7%BD%AE
 */
 namespace app\api\controller\v1;
 use app\api\v1\Token as TokenValidator;
 use app\api\service\UserToken;

 class Token{
    public function getToken($code = '') {
        (new TokenValidator)->goCheck();
        $ut = new UserToken($code);
        $token = $ut->get();
        return [
            'token' => $token
        ];
    }
 }

