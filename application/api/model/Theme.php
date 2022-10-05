<?php
/*
 * @Author: alimzhan 15365185687@qq.com
 * @Date: 2022-09-11 12:01:33
 * @LastEditors: alimzhan 15365185687@qq.com
 * @LastEditTime: 2022-10-02 17:17:17
 * @FilePath: \think-5.0.7\application\api\model\Theme.php
 * @Description: 这是默认设置,请设置`customMade`, 打开koroFileHeader查看配置 进行设置: https://github.com/OBKoro1/koro1FileHeader/wiki/%E9%85%8D%E7%BD%AE
 */

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
        if(!$result) {
            throw new ThemeException();
        }
        return $result;
    }
}