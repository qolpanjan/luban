<?php
/*
 * @Author: alimzhan 15365185687@qq.com
 * @Date: 2022-10-02 14:57:28
 * @LastEditors: alimzhan 15365185687@qq.com
 * @LastEditTime: 2022-10-05 10:51:07
 * @FilePath: \think-5.0.7\application\api\service\Token.php
 * @Description: 这是默认设置,请设置`customMade`, 打开koroFileHeader查看配置 进行设置: https://github.com/OBKoro1/koro1FileHeader/wiki/%E9%85%8D%E7%BD%AE
 */

 namespace app\api\service;

 use think\Request;
 use think\Cache;
 use app\lib\exception\TokenException;
 use app\api\service\Token;
 use app\lib\exception\UnAuthorizedException;
 use app\lib\enum\ScopeEnum;


 class Token
 {
    public static function generateToken() {
        // 32个字符串组成一组随机字符串
        $random = getRandChars(32);
        // 用三组字符串进行md5加密
        $timestamp = $_SERVER['REQUEST_TIME_FLOAT'];
        // salt 盐
        $salt = config('secure.token_salt');

        return md5($random.$timestamp.$salt);
    }

    public static function getCurrentTokenVar($key) {
        $token = Request::instance()->header('token');
        $value = Cache::get($token);
        if (!$value) {
            throw new TokenException();
        } else {
            if (!is_array($value)) {
                $value = json_decode($value, true);
            }
        }
        if (array_key_exists($key, $value)) {
            return $value[$key];
        } else {
            throw new Exception('缓存中不存在指定的变量');
        }
    }

    /**
     * 根据token从缓存获取用户uid和openid信息
     */
    public static function getCurrentUserUid() {
        $uid = self::getCurrentTokenVar('uid');
        return $uid;
    }

    public static function getCurrentUserScope() {
        return self::getCurrentTokenVar('scope');
    }

    public static function checkExclusiveScope() {
        $scope = self::getCurrentUserScope();
        if ($scope) {
            if ($scope == ScopeEnum::APP_USER) {
                return true;
            } else {
                throw new UnAuthorizedException();
            }
        } else {
            throw new TokenException();
        }
    }

    public static function checkPrimaryScope() {
        $scope = self::getCurrentUserScope();
        if ($scope) {
            if ($scope >= ScopeEnum::APP_USER) {
                return true;
            } else {
                throw new UnAuthorizedException();
            }
        } else {
            throw new TokenException();
        }
    }
 }