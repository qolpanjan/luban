<?php
/*
 * @Author: alimzhan 15365185687@qq.com
 * @Date: 2022-10-02 14:57:28
 * @LastEditors: alimzhan 15365185687@qq.com
 * @LastEditTime: 2022-10-06 13:30:17
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
    /**
     * 生成32位随机字符串算法
     */
    public static function generateToken() {
        // 32个字符串组成一组随机字符串
        $random = getRandChars(32);
        // 用三组字符串进行md5加密
        $timestamp = $_SERVER['REQUEST_TIME_FLOAT'];
        // salt 盐
        $salt = config('secure.token_salt');

        return md5($random.$timestamp.$salt);
    }

    /**
     * 根据请求中的token获取指定的参数
     */
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
     * 根据token从缓存获取用户uid
     */
    public static function getCurrentUserUid() {
        $uid = self::getCurrentTokenVar('uid');
        return $uid;
    }

    /**
     * 根据token从缓存获取用户的scope
     */
    public static function getCurrentUserScope() {
        return self::getCurrentTokenVar('scope');
    }

    /**
     * 检查是否只有app用户权限
     */
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

    /**
     * 检查是否有app用户以上的权限
     */
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

    /**
     * 检查传入的uid是不是缓存在中当前uid（根据token检查uid，也就是说传入的token和uid是否匹配）
     */
    public static function isValidUserOperate($checkedUid)
    {
        if (!$checkedUid)
        {
            throw new Exception('检测uid是必须传入合法的用户uid');
        }

        $currentOperateUID = self::getCurrentUserUid();
        if ($checkedUid == $currentOperateUID)
        {
            return true;
        }
        return false;
    }
 }