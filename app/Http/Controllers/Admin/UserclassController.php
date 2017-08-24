<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Session;

class UserclassController extends CommonController
{
    //用户类型列表
    //查询数据
    public function index(Request $request)
    {
        $data = DB::table('user_type')
                    -> join('admin','user_type.clert','=','admin.id')
                    -> select('user_type.*','admin.name as uname')
                    -> paginate(10);
        foreach($data as $k => $v)
        {
            $v -> created_at = date('Y-m-d H:i:s',$v -> created_at);
            $v -> updated_at = date('Y-m-d H:i:s',$v -> updated_at);

        }
                    // var_dump($data);die;
        return view('admin.user.userclass.userClassList',['data'=> $data,'request' => $request -> all()]);
    }

    //添加页面
    public function add()
    {
        return view('admin.user.userclass.userClassAdd');
    }

    //执行添加
    public function insert(Request $request)
    {
        $data = $request -> except('_token','s');
        if($data['month_money'] == null)
        {
            $data['month_money'] = 0;
        }
        if($data['year_money'] == null)
        {
            $data['year_money'] = 0;
        }
        $data['clert'] = Session('admin') ? Session('admin') : 0;
        $data['created_at'] = time();
        $data['updated_at'] = time();
        $res = DB::table('user_type') -> insert($data);
        if($res)
        {
            return redirect('admin/user/userclass/userClassList') -> with(['info'=> '添加成功']);
        }else
        {
            return back() -> with(['info'=> '添加失败']);
        }

    }

    //修改页
    public function change($id)
    {
        //查询数据
        $data = DB::table('user_type') -> where('id',$id) -> first();
        return view('admin/user/userclass/userClassChange',['data' => $data]);
    }

    //执行修改
    public function update(Request $request,$id)
    {
        $data = $request -> except('_token','repassword','s');
        $data['updated_at']=time();
        //更新数据表
        $res = DB::table('user_type') -> where('id',$id) -> update($data);
        //判断操作是否成功
        if($res)
        {
           return redirect('admin/user/userclass/userClassList') -> with(['info' => '更新成功']);
        }else
        {
            return redirect('admin/user/userclass/userClassChange') -> with(['info' => '更新失败']);
        }
    }

    //执行删除
    public function delete($id)
    {
        //判断类型是否可删除
        //查询用户表中有无使用此类型的胡用户
        $r = DB::table('users') -> where('usertype',$id) -> first();
        if(!$r)
        {
            $res = DB::table('user_type') -> delete($id);
            //判断操作是否成功
            if($res)
            {
                return redirect('admin/user/userclass/userClassList') -> with(['info' => '删除成功']);
            }else
            {
                return back() -> with(['info' => '删除失败']);
            }

        }else
        {
            return back() -> with(['info' => '此类型正在使用，不可删除']);
        }


    }
}
