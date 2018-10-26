<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/16 0016
 * Time: 17:05
 */

namespace app\http\middleware;


class Auth
{
    public function handle($request, \Closure $next)
    {
        $input = new Input();


        return $next($request);
    }

}