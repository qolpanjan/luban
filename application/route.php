<?php
/*
 * @Author: alimzhan 15365185687@qq.com
 * @Date: 2022-08-22 23:33:01
 * @LastEditors: alimzhan 15365185687@qq.com
 * @LastEditTime: 2022-10-06 18:26:13
 * @FilePath: \think-5.0.7\application\route.php
 * @Description: 这是默认设置,请设置`customMade`, 打开koroFileHeader查看配置 进行设置: https://github.com/OBKoro1/koro1FileHeader/wiki/%E9%85%8D%E7%BD%AE
 */
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

use think\Route;

Route::get('api/:version/banner/:id', 'api/:version.Banner/getBanner');

Route::get('api/:version/theme/:id', 'api/:version.Theme/getComplexOne');

Route::get('api/:version/theme', 'api/:version.Theme/getSimpleList');

Route::get('api/:version/product/recent', 'api/:version.Product/getRecent');
Route::get('api/:version/product/:id', 'api/:version.Product/getOne', [], ['id' =>'\d+']);

Route::get('api/:version/category/all', 'api/:version.Category/getAllCategory');

Route::get('api/:version/category/:id', 'api/:version.Category/getOneCategory');

Route::post('api/:version/token/user', 'api/:version.Token/getToken');

Route::post('api/:version/address', 'api/:version.Address/createOrUpdateAddress');

Route::post('api/:version/order', 'api/:version.Order/placeOrder');
Route::get('api/:version/order/page', 'api/:version.Order/getByPage');

Route::post('api/:version/pay/pre_order', 'api/:version.Pay/getPreOrder');