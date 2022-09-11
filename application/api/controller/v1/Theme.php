<?php

namespace app\api\controller\v1;

use app\api\validate\IdCollection;
use app\api\validate\IdMustBePositiveInt;
use app\api\model\Theme as ThemeModel;


class Theme
{
    /**
     * @url /theme?ids=id1,id2,...
     * @return 一组theme模型
     */
    public function getSimpleList($ids = '') {
        (new IdCollection())->goCheck();
        $ids = explode(',', $ids);
        return ThemeModel::getThemeByIDs($ids);
    }

    /**
     * @url /theme/:id
     * @return 一个theme下面的产品
     */
    public function getComplexOne($id) {
        (new IdMustBePositiveInt)->goCheck();
        return ThemeModel::getThemeWithProducts($id);
    }
}
