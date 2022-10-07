<?php
/*
 * @Author: alimzhan 15365185687@qq.com
 * @Date: 2022-10-05 10:15:26
 * @LastEditors: alimzhan 15365185687@qq.com
 * @LastEditTime: 2022-10-07 14:06:25
 * @FilePath: \think-5.0.7\application\api\controller\v1\Order.php
 * @Description: 这是默认设置,请设置`customMade`, 打开koroFileHeader查看配置 进行设置: https://github.com/OBKoro1/koro1FileHeader/wiki/%E9%85%8D%E7%BD%AE
 */
namespace app\api\controller\v1;

use app\api\service\Token;
use app\lib\exception\UnAuthorizedException;
use app\lib\exception\TokenException;
use app\api\validate\OrderValidate;
use app\api\service\OrderService;
use app\api\validate\PageParameterValidate;
use app\api\model\Order as OrderModel;

class Order extends BaseController
{
    protected $beforeActionList = [
        'checkExclusiveScope' => ['only', 'placeOrder'],
        'checkPrimaryScope' =>['only','getByPage']
    ];
    
    public function getByPage($page = 1, $size = 15)
    {
        (new PageParameterValidate)->goCheck();
        $uid = Token::getCurrentUserUid();
        $pagingOrders = OrderModel::getSummaryByUser($uid, $page, $size);
        if ($pagingOrders->isEmpty()) {
            return [
                'data' => [],
                'current_page' => $pagingOrders->getCurrentPage()
            ];
        }
        $data = $pagingOrders->hidden(['snap_items','snap_address','prepay_id'])->toArray();
        return [
            'data' => $data,
            'current_page' => $pagingOrders->getCurrentPage()
        ];
    }

    /**
     * 1、用户选择商品，想服务器提交商品信息
     * 2、服务器收到商品信息以后，需要检查订单相关商品的库存量
     * 3、有库存，把订单数据存入数据库中=下单成功，返回客户端可以支付
     * 4、客户端调用支付接口，进行支付
     * 5、支付之前需要再次发起库存量检测
     * 6、服务器调用微信支付接口进行支付
     * 7、接受微信返回的支付结果
     * 8、成功，检查库存量，进行库存量的扣除，以及支付失败后的结果反馈
     */
    public function placeOrder() {
        (new OrderValidate())->goCheck();
        $products = input('post.products/a');
        $uid = Token::getCurrentUserUid();

        $orderService = new OrderService();
        $status = $orderService->place($uid, $products);
        return $status;
    }
}