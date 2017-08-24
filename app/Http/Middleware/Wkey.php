<?php

namespace App\Http\Middleware;

use App\Http\Models\Config;
use Closure;

class Wkey
{
    /**
     * 网站开关
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $config = Config::first()->toArray();
        if($config['wkey'] == 0){
            return redirect('wkey');
            //return view('welcome');//网站暂时关闭
        }

        return $next($request);
    }
}
