<?php

namespace app\api\controller\v1;

use app\api\validate\Count;
use app\api\model\Product as ProductModel;

class Product
{
    public function getRecent($count = 15) {
        (new Count)->goCheck();
        return ProductModel::getRecentProduct($count);
    }
}