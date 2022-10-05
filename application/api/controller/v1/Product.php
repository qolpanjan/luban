<?php
/*
 * @Author: alimzhan 15365185687@qq.com
 * @Date: 2022-09-11 16:49:07
 * @LastEditors: alimzhan 15365185687@qq.com
 * @LastEditTime: 2022-10-02 17:55:22
 * @FilePath: \think-5.0.7\application\api\controller\v1\Product.php
 * @Description: 这是默认设置,请设置`customMade`, 打开koroFileHeader查看配置 进行设置: https://github.com/OBKoro1/koro1FileHeader/wiki/%E9%85%8D%E7%BD%AE
 */

namespace app\api\controller\v1;

use app\api\validate\Count;
use app\api\model\Product as ProductModel;
use app\api\validate\IdMustBePositiveInt;

class Product
{
    /**
     * 获取最近发布的15个商品，用于在主页下面显示
     */
    public function getRecent($count = 15) {
        (new Count)->goCheck();
        $res =  ProductModel::getRecentProduct($count);
        $products = $res->hidden(['summary']);
        return $products;
    }

    /**
     * 获取单个商品的详细资料
     */
    public function getOne($id) {
        (new IdMustBePositiveInt)->goCheck();
        $product =  ProductModel::getProductDetail($id);
        return $product;
    }

}