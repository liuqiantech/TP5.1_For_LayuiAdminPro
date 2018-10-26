<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/26 0026
 * Time: 15:48
 */

namespace app\common\service;


use app\common\exception\CommonException;
use Firebase\JWT\JWT;
use think\Cache;
use think\Facade;

class Token
{
    protected $tokenSecret;
    protected $tokenAlg;
    protected $tokenIss;
    protected $tokenLifetime;
    protected $tokenCache;
    protected $tokenPrefix;
    public $uid;
    public function __construct()
    {
        if(is_null(config('token.token_secret'))){
            throw new CommonException(1001,'Token私钥未设置');
        }else{
            $this->tokenSecret =   config('token.token_secret');
        }
        $this->tokenAlg =   config('token.token_alg')  ??  '';
        $this->tokenIss =   config('token.token_iss')  ??  '';
        $this->tokenLifetime =   is_numeric(config('token.token_lifetime'))?config('token.token_lifetime')*60*60    :  8*60*60;
        $this->tokenCache =   config('token.token_cache')    ??  '';
        $this->tokenPrefix =   config('token.token_prefix')    ??  '';
        if($this->tokenCache  ==  'AliRedis'){
            Facade::bind('AliyunRedis' , 'app\common\controller\AliyunRedis');
        }

    }

    /**生成token
     * @param $uid  //用户UD
     * @param string $lifetime  //token有效期
     * @return string
     * @throws CommonException
     */
    public function create($uid, $lifetime=''){
        if(is_null($uid)){
            throw new CommonException(1001,'Token:未指定UID');
        }
        //token发布者
        $payload['iss']  =  $this->tokenIss ;
        //用户ID
        $payload['uid']  =  $uid ;
        //发布时间
        $payload['iat']  =  time() ;

        $expire  =  is_numeric($lifetime) ?    $lifetime   :     $this->tokenLifetime;
        $expireTime =   $payload['iat'] +   $expire;
        if($expireTime-time()<60){
            throw new CommonException(1001,'Token:有效期设置错误');
        }
        //过期时间
        $payload['exp'] =   $expireTime;

        $jwt    =   JWT::encode($payload,$this->tokenSecret,$this->tokenAlg);
        if($jwt){
            $this->tokenCache($uid,$jwt,$expire);
            return $jwt;
        }else{
            throw new CommonException(1001,'Token:系统生成token失败！');
        }
    }

    /** 缓存token
     * @param $uid  //用户ID
     * @param $token    //token值
     * @param $lifetime //token有效期（秒）
     * @return bool
     * @throws CommonException
     */
    //todo:本地文件缓存的机制
    public function tokenCache($uid,$token,$lifetime){
        if(class_exists(\Redis::class)==false&&$this->tokenCache!='mysql'){
            throw new CommonException(1001,'Token：服务器不支持Php-Redis扩展，请使用mysql方式');
        }
        //AliRedis 写入
        if($this->tokenCache  ==  'AliRedis'){
            \app\facade\AliyunRedis::delete($this->tokenPrefix.$uid);
            $tokenCache = \app\facade\AliyunRedis::set($this->tokenPrefix.$uid,$token,$lifetime);
            if($tokenCache == false){
                throw new CommonException(1001,'Token：AliRedis写入失败');
            }else{
                return true;
            }
        }
        //本地Redis
        if($this->tokenCache == 'redis'){
            \think\facade\Cache::rm($this->tokenPrefix.$uid);
            $tokenCache =   \think\facade\Cache::store('redis')->set($this->tokenPrefix.$uid,$token,$lifetime);
            if($tokenCache == false){
                throw new CommonException(-1,'Token：本地Redis写入失败');
            }else{
                return true;
            }
        }
        //Mysql
        if($this->tokenCache == 'mysql'){
            $tokenModel =   config('token.token_model');
            $destoryToken   =   $tokenModel::where('uid','=',$uid)->delete();
            $tokenCache =$tokenModel::save(['uid'=>$uid,'token'=>$token]);
            if($tokenCache == false){
                throw new CommonException(1001,'Token：本地Mysql写入失败');
            }else{
                return true;
            }
        }
    }

    /** 获取token
     * @param $uid
     * @return mixed
     */
    public function getToken($uid){
        //todo:本地redis和mysql获取
        $tokenKey   =   $this->tokenPrefix.$uid;
        return  \app\facade\AliyunRedis::get($tokenKey);
    }

    /**验证token是否正确
     * @param $token
     * @return bool
     * @throws CommonException
     */
    public function tokenVerify($token){
        if(false==$token){
            throw new CommonException(1001,'Token:Token信息不存在');
        }
        $tokenArray = explode('.',$token);
        $userStr = base64_decode($tokenArray['1']);
        $userInfo=json_decode($userStr,true);
        if(false===isset($userInfo['uid'])){
            throw new CommonException(1001,'Token:用户信息不存在');
        }
        $tokenCached    =   $this->getToken($userInfo['uid']);
        if($tokenCached!==$token){
            throw new CommonException(1001,'Token:Token验证错误');
        }
        //*mysql存储机制下 无法设置数据有效期，需单独验证有效期
        if($this->tokenCache == 'mysql' &&  $userInfo['exp']<time()){
            throw new CommonException(1001,'Token:登录已过期');
        }
        $this->uid  =   $userInfo['uid'];
        return true;
    }
}