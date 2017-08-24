<?php

namespace App\Http\Controllers\Admin;

use App\Http\Models\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class ConfigController extends CommonController
{
    //
    public function index()
    {
        $data = Config::first();
        return view('admin.baseset.setList')->with('data',$data);
    }

    public function update()
    {
        if($input = Input::except('_token','s')){
            $rules = [
                'webname' => 'required',
                'webemail' => 'required|email',
                'weburl' => 'required',
                'webkeywords' => 'required',
                'webdescription' => 'required',
                'wname' => 'required',
                'wtel' => 'required',
                'wtel1' => 'required',
                'waddress' => 'required',
                'wcopyright' => 'required',
                'wstatement' => 'required',
                'qq_kf' => 'required|numeric',
            ];
            $messages = [
                'webname.required' => '网站名称不能为空！',
                'webemail.required' => '网站邮箱不能为空！',
                'webemail.email' => '网站邮箱格式错误！',
                'weburl.required' => '网站域名不能为空！',
                'webkeywords.required' => '网站关键字不能为空！',
                'webdescription.required' => '网站描述不能为空！',
                'wname.required' => '公司名称不能为空！',
                'wtel.required' => '公司电话不能为空！',
                'wtel1.required' => '公司电话1不能为空！',
                'waddress.required' => '公司地址不能为空！',
                'wcopyright.required' => '公司版权不能为空！',
                'wstatement.required' => '注册声明不能为空！',
                'qq_kf.required' => 'QQ客服不能为空！',
                'qq_kf.numeric' => 'QQ客服只能为数字！',
            ];
            $validator = Validator::make($input,$rules,$messages);
            if($validator->passes()){
                if(Config::where('id',1)->get()->first())
                    $res = Config::first()->update($input);
                else
                    $res = Config::create($input);
                //return $res ? back()->with('errors','配置修改成功！') : back()->with('errors','配置修改失败，请稍后重试！');
                //return redirect('admin/config');
                return $res ? ['state'=>'1', 'msg'=>'配置修改成功！'] : ['state'=>'0', 'msg'=>'配置修改失败，请稍后重试！'];
            }
            //return back()->withErrors($validator);
            return ['state'=>'0', 'msg'=>$validator->errors()->first()];
        }else
            return view('admin.config.update');
    }
}
