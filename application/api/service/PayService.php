<?php
/*
 * @Author: alimzhan 15365185687@qq.com
 * @Date: 2022-10-06 12:57:40
 * @LastEditors: alimzhan 15365185687@qq.com
 * @LastEditTime: 2022-10-06 18:00:37
 * @FilePath: \think-5.0.7\application\api\service\PayService.php
 * @Description: 这是默认设置,请设置`customMade`, 打开koroFileHeader查看配置 进行设置: https://github.com/OBKoro1/koro1FileHeader/wiki/%E9%85%8D%E7%BD%AE
 */

 namespace app\api\service;

 use app\api\model\Order as OrderModel;
 use app\api\service\Token as TokenService;
 use app\lib\exception\OrderException;
 use app\lib\enum\OrderStatusEnum;
 use think\Loader;

 // extend/WxPay/WxPay.Api.php
 Loader::import('WxPay.WxPay', EXTEND_PATH, '.Api.php');

 class PayService
 {
    private $orderId;
    private $orderNo;

    function __construct($orderId)
    {
        if(!orderId)
        {
            throw new Exception('订单号不允许为空');
        }
        $this->orderId = $orderId;
    }

    public function pay()
    {

        $this->checkOrderValidate();
        $orderService = new OrderService();
        $status = $orderService->checkOrderStock($this->orderId);
        if (!status['pass'])
        {
            return $status;
        }
        //向微信的请求支付
        $this->makePreOrder($status['orderPrice']);

    }

    /**
     * 向微信请求prepayId
     */
    private function makePreOrder($totalPrice)
    {
        // 订单号，用户的openId
        $openId = TokenService::getCurrentTokenVar('openid');
        if (!$openId) {
            throw new TokenException();
        }
        // 没有命名空间需要添加小斜杠
        $wxOrderData = new \WxPayUnifiedOrder();
        $wxOrderData->SetOut_trade_no($this->$orderNo);
        $wxOrderData->SetTrade_type('JSAPI');
        $wxOrderData->SetTotal_fee($totalPrice * 100);
        $wxOrderData->SetBody('巧修匠家电维修');
        $wxOrderData->setOpenId($openId);
        $wxOrderData->SetNotify_url('http://qiaoxiujiang.com/'); //接受支付结果的回调

        return $this->getPaySignature($wxOrderData);

    }

    private function getPaySignature($wxOrderData)
    {
        // 向微信发送请求，获取已支付ID
        $wxOrder = \WxPayApi::unifiedOrder(wxOrderData);
        if ($wxOrder['return_code'] != 'SUCCESS' || $wxOrder['result_code'] != 'SUCCESS')
        {
            Log::record($wxOrder, 'error');
            Log::record('获取预支付订单失败', 'error');
        }
        $this->recordPrepayID($wxOrder);
        $signature = $this->sign($wxOrder);
        return $signature;
    }

    // 生成签名，供前端调佣支付接口
    private function sign($wxOrder)
    {
        $jsApiPayData = new \WxPayJsApiPay();
        $jsApiPayData->SetAppid(config('wx.app_id'));
        $jsApiPayData->SetTimeStamp((string)time());

        $rand = md5(time().mt_rand(0, 1000));
        $jsApiPayData->SetNonceStr($rand);

        $jsApiPayData->SetPackage('prepay_id='.$wxOrder['prepay_id']);
        $jsApiPayData->SetSignType('md5');

        $sign = $jsApiPayData->MakeSign();
        $rawValue = $jsApiPayData->GetValues();
        $rawValue['paySign'] = $sign;
        unset($rawValue['appId']);
        return $rawValue;
    }

    private function recordPrepayID($wxOrder)
    {
        OrderModel::where('id', '=', $this->orderId)
            ->update(['prepay_id' => $wxOrder['prepay_id']]);
    }

    /**
     * 检查订单
     * 1、订单号可能不存在
     * 2、订单号确实存在，订单号和当前用户不匹配
     * 3、订单可能已经被支付
     */
    private function checkOrderValidate()
    {
        // 检查订单号是否存在
        $order = OrderModel::where('orderId', '=',$this->orderId)->find();
        if (!$order) {
            throw new OrderException();
        }

        // 检查订单与当前用户是否匹配
        if (!TokenService::isValidUserOperate($order->user_id)) {
            throw new TokenException([
                'msg' => '订单与用户不匹配',
                'errorCode' => 10003,
            ]);
        }

        // 检查订单是否已支付
        if ($order->status != orderStatusEnum::UNPAID) 
        {
            throw new OrderException([
                'msg' => '订单状态为已支付',
                'errorCode' => 80003,
                'code' => 400
            ]);
        }
        $this->$orderNo = $order->order_no;
        return true;
    }

 }