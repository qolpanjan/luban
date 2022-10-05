<?php
/*
 * @Author: alimzhan 15365185687@qq.com
 * @Date: 2022-09-12 10:52:57
 * @LastEditors: alimzhan 15365185687@qq.com
 * @LastEditTime: 2022-10-02 15:35:50
 * @FilePath: \think-5.0.7\application\api\model\Category.php
 * @Description: 这是默认设置,请设置`customMade`, 打开koroFileHeader查看配置 进行设置: https://github.com/OBKoro1/koro1FileHeader/wiki/%E9%85%8D%E7%BD%AE
 */

namespace app\api\model;

use think\Model;
use app\lib\Exception\ProductMissException;

class Category extends BaseModel
{
    protected $hidden = ['delete_time','update_time'];

    public function img() {
        return $this->belongsTo('Image', 'topic_img_id', 'id');
    }
}