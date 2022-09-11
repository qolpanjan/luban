<?php

namespace app\api\model;

use think\Model;
use app\lib\Exception\ProductMissException;

class Product extends BaseModel
{
    protected $hidden = ['delete_time','create_time', 'update_time','pivot', 'from', 'category_id'];

    public function getMainImgUrlAttr($value, $data) {
        return $this->getImgPrefix($value, $data);
    }

    public static function getRecentProduct($count) {
        // limit限制查询数量 order查询结果拍讯
        $products = self::limit($count)->order('create_time desc')->select();
        if($products->isEmpty()) {
            throw new ProductMissException();
        }
        return $products;
    }
}