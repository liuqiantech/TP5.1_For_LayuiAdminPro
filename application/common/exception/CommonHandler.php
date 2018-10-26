<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/24 0024
 * Time: 9:49
 */

namespace app\common\exception;


use think\exception\Handle;
use think\exception\HttpResponseException;
use think\facade\Request;
use think\exception\RouteNotFoundException;
use think\exception\ValidateException;
use think\db\exception\ModelNotFoundException;

class CommonHandler extends Handle
{
    public function render(\Exception $e)
    {
//
//        if(true === config('app_debug')){
//            return parent::render($e);
//        }
//
//        if($e instanceof CommonException){
//
//          return $this->getRealMessage($e->status,$e->msg,$e->data,$e->url);
//        }
//
//        return parent::render($e);

        $message = $e->getMessage();
        switch (true) {
            case $e instanceof CommonException:
                return self::getRealMessage($e->status,$e->msg,$e->data,$e->url);
                break;
            case $e instanceof ValidateException:
                return self::getRealMessage(-1,$message,'','');
                break;
            case $e instanceof ModelNotFoundException:
                return self::getRealMessage(-1,$message,'','');
                break;
            case $e instanceof RouteNotFoundException:
                return self::getRealMessage(-1,$message,'','');
                break;
            default:
               // self::saveAllData($exception);
                return parent::render($e);
                break;
        }
    }

    public function toJson($msg,$data,$url){
                    $returnData['code'] =   0;
            $returnData['status'] =   1;
            $returnData['msg'] =   $msg;
            $returnData['data'] =   $data;
            $returnData['url']  =   $url;
            return json($returnData);
    }

    public function getRealMessage($status,$msg,$data,$url){
        try{
            switch(true){
                case $status === 1:
                    return self::success($msg,$data,$url);
                break;
                case $status === 0:
                    return self::logout($msg,$data,$url);
                    break;
                default:

                    return self::error($status,$msg,$data,$url);
            }
        }catch (HttpResponseException $e){
            return parent::render($e);
        }
    }
    public static function success($msg,$data='',$url=''){

        if(true === Request::isAjax()){
            $returnData['code'] =   0;
            $returnData['status'] =   1;
            $returnData['msg'] =   $msg;
            $returnData['data'] =   $data;
            $returnData['url']  =   $url;
            return json($returnData);
        }else{
            return \response($msg);
        }
    }
    public static function logout($msg,$data='',$url=''){
        if(true === Request::isAjax()){
            $returnData['code'] =   1001;
            $returnData['status'] =   0;
            $returnData['msg'] =   $msg;
            $returnData['data'] =   $data;
            $returnData['url']  =   $url;
            return json($returnData);
        }else{
            return \response($msg);
        }
    }
    public static function error($status,$msg,$data='',$url=''){
        if(true === Request::isAjax()){
            $returnData['code'] =   0;
            $returnData['status'] =   $status;
            $returnData['msg'] =   $msg;
            $returnData['data'] =   $data;
            $returnData['url']  =   $url;
            return json($returnData);
        }else{
            return \response($msg);
        }
    }
}