<?php
/**
 * Created by PhpStorm.
 * User: hideb
 * Date: 2018/10/27
 * Time: 12:50
 */

namespace app\index\controller;


use app\index\logic\LoginLogic;

class Login
{
    protected $loginLogic;
    public function __construct()
    {
        $this->loginLogic =   new LoginLogic();
    }
    public function login(){
        return $this->loginLogic->login();
    }
}