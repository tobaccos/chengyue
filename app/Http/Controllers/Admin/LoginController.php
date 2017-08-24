<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Hash;
use Session;

class LoginController extends Controller
{
    //执行登录
    public function login(Request $request)
    {
    	//判断路径类型是否为post
    	if($request -> isMethod('post'))
    	{
    		//进行数据验证
    		// $this -> validate($request,[
    		// 	'name' => 'required',
    		// 	'password' => 'required',
    		// 	],[
    		// 	'name.required' => '用户名不能为空',
    		// 	'password.required' => '密码不能为空',
    		// 	]);
    		$data = $request -> except('_token');
            $captcha = session('milkcaptcha');
            if($data['captcha'] != $captcha)
            {
                return back() -> with(['info' => '验证码错误']);
            }
    		//查询数据
    		$res = DB::table('admin') -> where('name',$data['name']) ->where('state',0)-> first();
    		if(!$res)
    		{
    			return back() -> with(['info' => '用户名或密码错误']);
    		}

    		//密码进行加密
    		$r = Hash::check($data['password'],$res -> password);
    		if(!$r)
    		{
    			return back() -> with(['info' => '用户名或密码错误']);
    		}
    		//将管理员信息存入session中
    		Session::put('admin',$res->id);

    		return redirect('admin/index') -> with(['info' => '登录成功']);
    	}
    	return view('admin.login');
    }

    //退出登录
    public function logout()
    {
        Session::forget('admin');
    	Session::forget('ruleIndex');
    	return redirect('/admin/login') -> with(['info' => '退出成功']);
    }
}
