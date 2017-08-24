<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use DB;

class LoginMiddlewere
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        //判断session是否存在
        if(!Session::has('admin'))
        {
            //返回后台登录页面
            return redirect('admin/login') -> with(['info' => '请登录']);
        }
        return $next($request);
    }
}
