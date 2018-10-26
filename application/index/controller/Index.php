<?php
namespace app\index\controller;



use app\common\exception\CommonException;
use app\common\service\Aliyunoss;
use app\common\service\BaiduImageClassify;
use app\facade\Input;
use think\Exception;
use think\exception\HttpException;
use think\Facade;
use think\facade\Request;
use think\facade\Response;
use think\facade\Config;

class Index
{


    public function index()
    {

        throw new CommonException(0,'Token验证成功，UID为'.app('auth')->uid);


    }

    public function hello($name = 'ThinkPHP5')
    {
        phpinfo();
    }
    public function upload(){
        $file = request()->file('file');
        // 移动到框架应用根目录/uploads/ 目录


        if($file){
            $info = $file->validate(['size'=>2097152,'ext'=>'jpg,png,gif'])->move('./upload/');
            $data['object']   =   $info->getSaveName();
            $data['pathName']   =   $info->getPathname();
            $aliyunOss = new Aliyunoss($data);
        }
    }
}
