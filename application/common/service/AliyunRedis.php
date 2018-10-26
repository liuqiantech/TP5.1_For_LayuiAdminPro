<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/26 0026
 * Time: 10:59
 */

namespace app\common\service;


use app\common\exception\CommonException;
use think\facade\Cache;

class AliyunRedis
{
    //redis host 阿里云后台获取
    private static $host    ='r-uf6d6a09ed38ac94.redis.rds.aliyuncs.com'   ;
    //redis 密码 阿里云后台获取
    private static  $password   =   'ufeIXOncow4McRz2';
    //redis 端口 阿里云后台获取
    private static  $port   =   '6379';
    //redis 用户
    private static $user    =   'r-uf6d6a09ed38ac94';
    public $option  =   [
        'type'=>'redis',
        'expire'=>0,//默认不设置有效期
    ];
    protected $redis;
    public  function __construct()
    {
        $this->redis = new \Redis();
        if ($this->redis->connect(self::$host, self::$port) == false) {
            throw new CommonException(-1,$this->redis->getLastError());
        }
        if ($this->redis->auth(self::$password) == false) {
            throw new CommonException(-1,$this->redis->getLastError());
        }
        if ($this->redis->set("foo", "bar") == false) {
            throw new CommonException(-1,$this->redis->getLastError());
        }
    }
    public function set($name,$value,$expire=''){

        return $this->redis->set($name,$value,$expire);
    }
    public function get($name){
        return $this->redis->get($name);
    }
    public function delete($name){
        return $this->redis->delete($name);
    }
}