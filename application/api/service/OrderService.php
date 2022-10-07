<?php
/*
 * @Author: alimzhan 15365185687@qq.com
 * @Date: 2022-10-05 15:31:16
 * @LastEditors: alimzhan 15365185687@qq.com
 * @LastEditTime: 2022-10-06 13:11:35
 * @FilePath: \think-5.0.7\application\api\service\OrderService.php
 * @Description: 这是默认设置,请设置`customMade`, 打开koroFileHeader查看配置 进行设置: https://github.com/OBKoro1/koro1FileHeader/wiki/%E9%85%8D%E7%BD%A
 */

namespace app\api\service;

use app\api\model\Product as ProductModel;
use app\api\model\UserAddress;
use app\api\model\Order as OrderModel;
use app\api\model\OrderProduct as OrderProductModel;
use think\Db;

class OrderService
{
    private $orderProducts;

    private $stockProducts;

    private $uid;

    public function place($uid, $orderProducts)
    {
        $this->$orderProducts = $orderProducts;
        $this->$uid = $uid;
        $this->stockProducts = $this->getProductStockByOrder($orderProducts);
        $status = $this->getOrderStatus();
        if(!$status['pass']) {
            $status['order_id'] = -1;
            return $status;
        }
        //开始创建订单
        $orderSnap = $this->snapOrder($status);
        $order =  $this->createOrder($orderSnap);
        $order['pass'] = true;
        return $order;
    }

    /**
     * 根据订单号查询已保存订单的状态(检查库存量)
     */
    public function checkOrderStock($orderId)
    {
        $this->orderProducts = OrderProductModel::where('order_id', '=', $orderId)->select();
        $this->stockProducts = $this->getProductStockByOrder($this->orderProducts);

        $status = $this->getOrderStatus();
        return $status;
    }

    /**
     * 将订单状态对象化
     */
    private function createOrder($snap)
    {
        Db::startTrans();
        try
        {
            $orderNumber = $this->makeOrderNo();
            $order = new OrderModel();
            $order ->user_id = $this->uid;
            $order ->order_no = $orderNumber;
            $order ->total_price - $snap['orderPrice'];
            $order ->total_count = $snap['totalCount'];
            $order ->snap_img = $snap['snapImg'];
            $order ->snap_name = $snap['snapName'];
            $order ->snap_address = $snap['snapAddress'];
            $order ->snap_items = json_encode($snap['snapStatusArray']);
            //保存订单表
            $order ->save();

            $orderId = $order->id;
            $create_time = $order->create_time;

            // 保存orderProduct中间表
            foreach($this->orderProducts as &$p) {
                $p['order_id'] = $orderId;
            }
            $orderProduct = new OrderProductModel();
            $orderProduct->saveAll($this->orderProducts);
            Db::commit();
            return [
                'order_no' => $orderNumber,
                'order_id' => $orderId,
                'create_time' => $create_time
            ];
        } catch (Exception $ex)
        {
            Db::rollback();
            throw $ex;
        }

    }

    /**
     * 生成订单号算法
     */
    public static function makeOrderNo()
    {
        $yCode = array('A','B','C','D','E','F','G','H','I','J','K');
        $orderSn = $yCode[intval(data('Y')) - 2022].strtoupper(dechex(date['m'])).date('d')
            .substr(time(), -5).substr(microtime(), 2, 5).sprintf('%02d',rand(0,99));
        return $orderSn;
    }

    /**
     * 生成订单快照信息
     */
    private function snapOrder($status)
    {
        $snap = [
            'orderPrice' => 0,
            'totalCount' => 0,
            'snapStatusArray' => [],
            'snapAddress' => null,
            'snapName' => '',
            'snapImage' => ''
        ];

        $snap['orderPrice'] = $status['orderPrice'];
        $snap['totalCount'] = $status['totalCount'];
        $snap['snapStatusArray'] = $status['productStatusArray'];
        $snap['snapAddress'] = json_encode($this->getUserAddress());
        $snap['snapName'] = $this->$stockProducts[0]['name'];
        $snap['snapImage'] = $this->$stockProducts[0]['main_img_url'];

        if (count($this->stockProducts) > 1) {
            $snap['snapName'] .='等';
        }
        return $snap;
    }

    /**
     * 获取用户地址
     * 根据用户的uid的查询用户的地址
     */
    private function getUserAddress()
    {
        $userAddress = UserAddress::where('user_id', '=', $this->$uid)->find();
        if (!$userAddress){
            throw new UserException([
                'msg' => '用户收货地址不存在，下单失败',
                'errorCode' => 60001,
            ]);
        }
        return $userAddress->toArray();
    }

    /**
     * 查询订单全部商品的状态
     */
    private function getOrderStatus()
    {
        $status = [
            'pass' => true,
            'orderPrice' => 0,
            'totalCount' => 0,
            'productStatusArray' => []  // 所有订单的详细信息
        ];

        foreach($this->orderProducts as $oProduct)
        {
            $oneProductStatus = $this->checkProductStock(
                $oProduct['product_id'], $oProduct['count'], $this->stockProducts
            );
            if (!$oneProductStatus['haveStock']) {
                $status['pass'] = false;
            }
            $status['orderPrice'] += $oneProductStatus['totalPrice'];
            $status['totalCount'] += $oneProductStatus['count'];
            array_push($status['productStatusArray'], $oneProductStatus);
        }

        return $status;
    }

    /**
     * 查询单个商品的库存状态
     *
     * @param $oPID 被查询商品的id
     * @param $orderCount 被查询商品的数量
     * @param $stockProducts 从数据库里查询的全部商品信息
     */
    private function checkProductStock($oPID, $orderCount, $stockProducts)
    {
        $index = -1;
        $oneProductStatus = [
            'id' => null,   //商品id
            'haveStock' => false, // 是否有库存
            'count' => 0, //订单商品数量
            'name' => '', //订单商品名称
            'totalPrice' => 0 //当前商品总价格
        ];

        for ($i = 0; $i < count($stockProducts); $i++){
            if ($oPID == $stockProducts[$i]['id']) {
                $index = $i;
            }
        }

        if ($index == -1)
        {
            throw new OrderException([
                'msg' => '订单中的商品已不存在，创建订单失败'
            ]);
        }else{
            $stockProduct = $stockProducts[$index];
            $oneProductStatus['id'] = $stockProduct['id'];
            $oneProductStatus['count'] = $orderCount;
            $oneProductStatus['totalPrice'] = $orderCount * $stockProduct['price'];
            if ($stockProduct['stock'] - $orderCount >= 0){
                $oneProductStatus['haveStock'] = true;
            }

        }
        return $oneProductStatus;
    }

    /**
     * 根据订单的商品id查询库存的商品
     *
     * @param @orderProducts 前端传过来的订单商品
     */
    private function getProductStockByOrder($orderProducts)
    {
        $pIds = [];
        foreach($orderProducts as $product) {
            array_push($pIds, $product['product_id']);
        }

        $stockProducts = ProductModel::all($pIds)
            ->visible(['id', 'price', 'stock', 'name', 'main_img_url'])
            ->toArray();

        return $stockProducts;
    }
}