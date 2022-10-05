<?php
/*
 * @Author: alimzhan 15365185687@qq.com
 * @Date: 2022-10-05 15:31:16
 * @LastEditors: alimzhan 15365185687@qq.com
 * @LastEditTime: 2022-10-05 16:25:52
 * @FilePath: \think-5.0.7\application\api\service\OrderService.php
 * @Description: 这是默认设置,请设置`customMade`, 打开koroFileHeader查看配置 进行设置: https://github.com/OBKoro1/koro1FileHeader/wiki/%E9%85%8D%E7%BD%A
 */

namespace app\api\service;

use app\api\model\Product as ProductModel;

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
        
    }

    /**
     * 查询
     */
    private function getOrderStatus()
    {
        $status = [
            'pass' => true,
            'orderPrice' => 0,
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