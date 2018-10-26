<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/24 0024
 * Time: 9:46
 */

namespace app\common\exception;


use think\Exception;

class CommonException extends Exception
{
    public $status;
    public $msg;
    public $data;
    public $url;
    public function __construct($status,$msg='',$data='',$url='')
    {
        $this->status   =       $status;
        $this->msg      =       $msg;
        $this->data     =       $data;
        $this->url      =       $url;

    }


}