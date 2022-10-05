<?php

namespace app\api\controller\v1;

use app\api\validate\IdMustBePositiveInt;
use app\api\model\Category as CategoryModel;
use app\api\model\Product as ProductModel;
use app\lib\exception\CategoryMissException;
use app\lib\exception\ProductMissException;
use think\response\Json;

class Category
{
    /**
     * 查询全部商品分类
     */
    public function getAllCategory(){
        $categories = CategoryModel::all([], 'img');
        if($categories->isEmpty()){
            throw new CategoryMissException();
        }
        return $categories;
    }

    /**
     * 根据分类查询分类下面的商品
     */
    public function getOneCategory($id) {
        (new IdMustBePositiveInt)->goCheck();
        $products = ProductModel::getProductByCategoryId($id);
        if($products->isEmpty()){
            throw new ProductMissException();
        }
        return $products;
    }
}