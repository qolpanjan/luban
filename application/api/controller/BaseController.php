<?php
/*
 * @Author: alimzhan 15365185687@qq.com
 * @Date: 2022-10-05 10:51:41
 * @LastEditors: alimzhan 15365185687@qq.com
 * @LastEditTime: 2022-10-05 10:51:46
 * @FilePath: \think-5.0.7\application\api\controller\BaseController.php
 * @Description: 这是默认设置,请设置`customMade`, 打开koroFileHeader查看配置 进行设置: https://github.com/OBKoro1/koro1FileHeader/wiki/%E9%85%8D%E7%BD%AE
 */
namespace app\api\controller;

use think\Controller;
use app\api\service\Token;

class BaseController extends Controller
{
    protected function checkPrimaryScope()
    {
        Token::checkPrimaryScope();
    }

    protected function checkExclusiveScope()
    {
        Token::checkExclusiveScope();
    }
}
