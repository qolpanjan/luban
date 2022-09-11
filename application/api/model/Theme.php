<?php

namespace app\api\model;

use think\Model;
use app\lib\exception\ThemeException;

class Theme extends BaseModel
{
    protected $hidden = ['delete_time','update_time','topic_img_id', 'head_img_id'];
    // 一对一关系获取图片
    // hasOne
    public function topicImg() {
        return $this->belongsTo('Image', 'topic_img_id', 'id');
    }


    public function headImg() {
        return $this->belongsTo('Image', 'head_img_id', 'id');
    }

    // 多对多关系 1、多对多的模型，2、中间表 ， 3、关联模型对应的外键， 4、本模型对应的外键
    public function products() {
        return $this->belongsToMany('Product', 'theme_product', 'product_id', 'theme_id');
    }

    public static function getThemeByIDs($ids) {
        $result = self::with(['topicImg','headImg'])->select($ids);
        if($result->isEmpty()) {
            throw new ThemeException();
        }
        return $result;
    }

    public static function getThemeWithProducts($id) {
        $result = self::with(['products', 'topicImg', 'headImg'])->find($id);
        if($result->isEmpty()) {
            throw new ThemeException();
        }
        return $result;
    }
}