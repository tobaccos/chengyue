<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use DB;
use Illuminate\Support\Facades\Session;
use URL;
use Illuminate\Support\Facades\Redis;

class HomeMiddleware
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
        Session::put('url',URL::previous());
        if(!Auth::Check())
        {
            if(isset($_GET['par'])){
                $par = $_GET['par'] ? $_GET['par'] : "";
                if($par != ""){
                    return redirect('/register?par='.$par);
                }
            }

            return redirect('/login');

        }


        //购物车数量
        $id = Auth::id();
        if(Auth::Check())
        {
            $res = Redis::get('Cart');
            $res = unserialize($res);
            if(isset($res['cart'][$id]) && !empty($res['cart'][$id]))
            {
                $cartNumber = count($res['cart'][$id]);
            }else{
                $cartNumber = '0';
            }
        }else{
            if(isset($_COOKIE['Cart']))
            {
                $res = $_COOKIE['Cart'];
                $res = unserialize($res);
                $cartNumber = count($res['cart']);
            }else{
                $cartNumber = '0';
            }
        }

        session() -> put('cartNumber',$cartNumber);

        $res = DB::table('users') -> where('id',$id) -> value('state');
        if($res == 1)
        {
            return redirect('/logout');
        }
        return $next($request);
    }
}
