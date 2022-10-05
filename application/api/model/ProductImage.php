<?php
/*
 * @Author: alimzhan 15365185687@qq.com
 * @Date: 2022-10-02 15:56:24
 * @LastEditors: alimzhan 15365185687@qq.com
 * @LastEditTime: 2022-10-02 17:43:00
 * @FilePath: \think-5.0.7\application\api\model\ProductImages
 * @Description: 这是默认设置,请设置`customMade`, 打开koroFileHeader查看配置 进行设置: https://github.com/OBKoro1/koro1FileHeader/wiki/%E9%85%8D%E7%BD%AE
 */
namespace app\api\model;

class ProductImage extends BaseModel
{
    protected $hidden = ['img_id', 'delete_time', 'product_id'];

    public function imgUrl() {
        return $this->belongsTo('Image', 'img_id', 'id');
    }
}