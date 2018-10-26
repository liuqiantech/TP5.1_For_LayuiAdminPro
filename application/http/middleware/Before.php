<?php

namespace app\http\middleware;

use app\common\controller\Input;
use think\facade\Request;
use think\facade\Response;

class Before
{
    public function handle($request, \Closure $next)
    {
        if(Request::method()=="OPTIONS"){
            return   \response('');
        };

        bind('input','app\common\controller\Input');
        app('input');
        bind('auth','app\common\controller\Auth');
        app('auth');
        return $next($request);
    }
}
