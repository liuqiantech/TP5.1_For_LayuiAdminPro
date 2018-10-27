<?php
/**
 * Created by PhpStorm.
 * User: hideb
 * Date: 2018/10/27
 * Time: 12:50
 */

namespace app\index\logic;


use app\common\exception\CommonException;
use app\common\service\Token;

class LoginLogic
{
    public function login(){
        $param  =   app('input')->input;
        if($param['username']!='admin'){
            throw new CommonException('1001','用户名不正确，请使用admin登录');
        }
        if($param['password']!='111111'){
            throw new CommonException('1001','密码不正确，请使用111111登录');
        }
        //以下为验证成功后的逻辑
        $tokenService = new Token();
        $token = $tokenService->create(1);
        if($token){
            throw new CommonException(1,'登录成功',['authorization'=>$token]);
        }else{
            throw new CommonException('1001','Token:Token生成失败');
        }
    }
}