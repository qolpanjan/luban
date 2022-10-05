<?php
/*
 * @Author: alimzhan 15365185687@qq.com
 * @Date: 2022-10-02 11:10:59
 * @LastEditors: alimzhan 15365185687@qq.com
 * @LastEditTime: 2022-10-02 18:05:43
 * @FilePath: \think-5.0.7\application\api\service\UserToken.php
 * @Description: 这是默认设置,请设置`customMade`, 打开koroFileHeader查看配置 进行设置: https://github.com/OBKoro1/koro1FileHeader/wiki/%E9%85%8D%E7%BD%AE
 */
namespace app\api\service\UserToken;

use app\api\model\User as UserModel;
use app\lib\exception\TokenException;
use app\lib\enum\ScopeEnum;


class UserToken extends Token
{
    protected $code;
    protected $wxAppID;
    protected $wxAppSecret;
    protected $wxLoginUrl;

    function __construct($code)
    {
        $this->code = $code;
        $this->wxAppID = config('wxConfig.app_id');
        $this->wxAppSecret = config('wxConfig.app_secret');
        $this->wxLoginUrl = sprintf(config('wx.login_url'), $this->wxAppID, $this->wxAppSecret, $this->code);
    }

    public function get() {
        $res = curl_get($this->wxLoginUrl);
        $wxResult = json_decode($res, true);
        if (empty($wxResult)) {
            throw new Exception('获取OpenID异常，微信内部错误');
        }else {
            $loginFail = array_key_exists('errorcode', $wxResult);
            if ($loginFail) {
                $this->processLoginError($wxResult);
            }else{
                $this->grantToken($wxResult);
            }
        }
    }

    private function grantToken($wxResult) {
        /**
         * 1、拿到openId
         * 2、数据库里查询是否存在该openId
         * 3、如果存在说明该用户已经注册
         * 4、如果不存在说明该用户还未注册，需要处理，新增一条user记录
         * 5、生成令牌，缓存数据
         * 6、把冷排返回到客户端
         */
        $openId = $wxResult['openid'];

        $user = UserModel::getOpenId($openId);
        if ($user) {
            $uid = $user->id;
        } else {
            $uid = $this->createUser($openId);
        }
        $cachedValue = $this->prepareCacheValue($wxResult, $uid);
        $token = $this->saveToCache($cachedValue);
        return $token;
    }

    private function saveToCache($cachedValue) {
        $key = self::generateToken();
        $value = json_encode($cachedValue);
        $expire_in = config('setting.token_expire_in');

        $request = cache($key, $value, $expire_in);
        if (!request) {
            throw new TokenException([
                'msg' => '服务器缓存异常',
                'errorcode' => 10005
            ]);
        }
        return $key;
    }

    private function prepareCacheValue($wxResult, $uid) {
        $cachedValue = $wxResult;
        $cachedValue['uid'] = $uid;
        $cachedValue['scope'] = ScopeEnum::APP_USER;
        return $cachedValue;
    }

    private function createUser($openid) {
        $user = UserModel::create([
            'openid'=>$openid
        ]);
        return $user->id;
    }

    private function processLoginError($wxResult) {
        throw new WechatException(
                [
                    'msg' => $wxResult['errmsg'],
                    'errorCode' => $wxResult['errorcode']
                ]
            );
    }
}