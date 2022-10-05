<?php

namespace app\api\model;

use app\lib\Exception\ProductMissException;

class Product extends BaseModel
{
    protected $hidden = ['delete_time','create_time', 'update_time','pivot', 'from', 'category_id'];

    public function imgs() {
        return $this->hasMany('ProductImage', 'product_id', 'id');
    }

    public function properties() {
        return $this->hasMany('ProductProperty', 'product_id', 'id');
    }

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

    public static function getProductByCategoryId($categoryID) {
        $products = self::where('category_id','=',$categoryID)->select();
        return $products;
    }

    public static function getProductDetail($id) {
        $productDetail = self::with([
            // 对imgs里的imgUrl按照order进行排序
            'imgs' => function ($query) {
                    $query->with('imgUrl')
                    ->order('order','ASC');
                }
            ])
            ->with(['properties'])
            ->find($id);
        if (!$productDetail) {
            throw new ProductMissException();
        }
        return $productDetail;
    }
}