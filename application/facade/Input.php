<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/23 0023
 * Time: 9:58
 */

namespace app\facade;


use think\Facade;

class Input extends Facade
{
    protected static function getFacadeClass()
    {
        return 'app\common\controller\Input';
    }
}