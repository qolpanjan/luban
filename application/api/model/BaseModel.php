<?php

namespace app\api\model;

use think\Model;

class BaseModel extends Model
{
    protected function getImgPrefix($value, $data) {
        $finalUrl = $value;
        if($data['from'] == 1) {
            $finalUrl = config('setting.img_prefix').$value;
        }
         // 获取图片资源前缀
        return $finalUrl;
    }
}