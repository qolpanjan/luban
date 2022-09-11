<?php

namespace app\api\model;

use think\Model;

class Image extends BaseModel
{
    protected $hidden = ['id', 'update_time', 'delete_time'];

    // url键的读取器
    public function getUrlAttr($value, $data) {
        return $this->getImgPrefix($value, $data);
    }
}