<?php
namespace app\index\controller;



use app\common\exception\CommonException;
class Index
{


    public function index()
    {

        throw new CommonException(0,'Token验证成功，UID为'.app('auth')->uid);


    }

}
