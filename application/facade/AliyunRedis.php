<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/26 0026
 * Time: 16:23
 */

namespace app\facade;


use think\Facade;

class AliyunRedis extends Facade
{
    protected static function getFacadeClass()
    {
        return 'app\common\service\AliyunRedis';
    }
}