<?php
/*
 * @Author: alimzhan 15365185687@qq.com
 * @Date: 2022-10-06 12:45:50
 * @LastEditors: alimzhan 15365185687@qq.com
 * @LastEditTime: 2022-10-06 18:57:06
 * @FilePath: \think-5.0.7\application\api\controller\v1\Pay.php
 * @Description: 这是默认设置,请设置`customMade`, 打开koroFileHeader查看配置 进行设置: https://github.com/OBKoro1/koro1FileHeader/wiki/%E9%85%8D%E7%BD%AE
 */

 namespace app\api\controller\v1;

 use app\api\controller\BaseController;
 use app\api\validate\IdMustBePositiveInt;
 use app\api\service\PayService;

 class Pay extends BaseController
 {

    protected $beforeActionList = [
        'checkExclusiveScope' => ['only', 'getPreOrder']
    ];

    public function getPreOrder($id = '')
    {
        (new IdMustBePositiveInt())->goCheck();
        /**
         * 1、检查库存
         * 2、向微信服务器发起请求获取prepayId
         * 3、将支付数据返回给客户端
         */
        $payService = new PayService();
        return $payService->pay();

    }

 }