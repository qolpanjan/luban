<?php

namespace app\api\model;

use think\Db;
use think\Exception;
use think\Paginator;
use think\Model;

class Banner extends Model
{
    // 隐藏当前类的字段属性
    protected $hidden = ['update_time','delete_time'];
    // 关联关系函数
    public function items(){
        // 1、关联模型的名称，2、外键  3、当前模型的主键，关联到关联模型的外键
        return $this->hasMany('BannerItem', 'banner_id', 'id');
    }
    public static function getBannerById($id)
    {
        //TODO:根据Banner ID号 获取banner
        //三种查询数据库
        $banner = self::with(['items', 'items.img'])->find($id);

        if(!$banner) {
            throw new BannerMissException();
        }
        return $banner;
    }
}