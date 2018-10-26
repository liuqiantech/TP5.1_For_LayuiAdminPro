<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/25 0025
 * Time: 15:09
 */
return [
    //是否开启token验证   bool
    'token_verify'=>true,

    //以下配置在token_verify=true情况下有效，跨域应用必须开启token验证

    //token名称   string
    'token_name'=>'Authorization',
    //token存放位置，header、param、cookie，跨域情况下cookie存放无效
    'token_position'=>'header',
    //token secret token私钥,
    'token_secret'=>'11111111111',
    //token 前缀 ,
    'token_prefix'=>'token_',
    //token加密方式
    'token_alg'=>'HS256',
    //token发布者，一般填写网站域名
    'token_iss'=>'xiaohariji.com',
    //token默认有效期（分钟），默认为8*60，
    'token_lifetime'=>'',
    //token存储位置，可选值 AliRedis、redis、mysql
    //redis 为本地redis模式，需要自行在config/cache.php配置
    'token_cache'=>'AliRedis',
    //如果token存储在mysql，则此处填写TP的模型名
    //表结构为 id  int 自增ID
    //uid int 用户ID
    //token varchar(255) token值
    'token_model'=>'TokenCache'

];