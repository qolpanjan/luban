<?php

namespace app\api\controller\v1;

use app\api\validate\IdMustBePositiveInt;
use app\api\model\Banner as BannerModel;
use app\lib\exception\BannerMissException;
use think\response\Json;

class Banner
{
    /**
     * 获取制定id的banner
     * @url: /banner/:id
     * @http GET
     * @param $id
     * @return void
     * @throws BannerMissException 不存在异常
     */
    function getBanner($id)
    {
        (new IdMustBePositiveInt())->goCheck();
        $banner = BannerModel::getBannerById($id);
        if(!$banner) {
            throw new BannerMissException();
        }
        return $banner;
    }
}