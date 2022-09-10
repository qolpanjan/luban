<?php

namespace app\api\model;

use think\Db;
use think\Exception;
use think\Paginator;

class Banner
{
    public static function getBannerById($id)
    {
        //TODO:根据Banner ID号 获取banner
        //三种查询数据库
        // 1、直接执行sql语句
        return Db::query('select * from banner where banner_id = ?',[$id]);
    }
}