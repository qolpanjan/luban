<?php
/*
 * @Author: alimzhan 15365185687@qq.com
 * @Date: 2022-10-02 17:56:19
 * @LastEditors: alimzhan 15365185687@qq.com
 * @LastEditTime: 2022-10-05 10:55:07
 * @FilePath: \think-5.0.7\application\api\controller\v1\Address.php
 * @Description: 这是默认设置,请设置`customMade`, 打开koroFileHeader查看配置 进行设置: https://github.com/OBKoro1/koro1FileHeader/wiki/%E9%85%8D%E7%BD%AE
 */
namespace app\api\controller\v1;

use app\api\validate\AddressValidate;
use app\api\service\Token;
use app\api\model\User as UserModel;
use app\lib\exception\UserException;
use app\lib\exception\SuccessMessage;
use app\lib\enum\ScopeEnum;
use app\lib\exception\UnAuthorizedException;
use app\lib\exception\TokenException;

class Address extends BaseController
{
    protected $beforeActionList = [
        'checkPrimaryScope' => ['only', 'createOrUpdateAddress']
    ];

    public function createOrUpdateAddress() {
        $validate = new AddressValidate();
        $validate>goCheck();
        /**
         * 1、获取用户的uid
         * 2、根据uid获取用户uid
         * 3、判断用户是否存在，若不存在抛出异常
         * 4、获取用户从客户端提交来的地址信息
         */
        $uid = Token::getCurrentUserUid();
        $user = UserModel::get($uid);
        if (!user) {
            throw new UserException();
        }

        //获取所有post提交的参数
        $dataArray = $validate->getDataByRule(input('post.'));

        $userAddress = $user->address;
        if (!$userAddress) {
            // 新增地址
            $user->address()->save($dataArray);
        } else {
            // 更新地址
            $user ->address->save($dataArray);
        }
        return new SuccessMessage();
    }
}