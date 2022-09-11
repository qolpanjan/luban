<?php

namespace app\api\model;

use think\Model;

class BannerItem extends Model
{
    protected $hidden = ['update_time', 'delete_time','id','img_id','banner_id'];
    public function img() {
        // 一对一关联模型 1、关联模型 2、外键 3、本类主键
        return $this->belongsTo('Image', 'img_id', 'id');
    }
}