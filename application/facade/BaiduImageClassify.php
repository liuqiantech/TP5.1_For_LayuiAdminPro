<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/18 0018
 * Time: 14:12
 */

namespace app\facade;


use think\Facade;

class BaiduImageClassify extends Facade
{
    protected static function getFacadeClass()
    {
        return 'app\common\service\BaiduImageClassify';
    }
}