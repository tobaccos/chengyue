<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Session;

class PartnerController extends CommonController
{
    //合作商家列表显示
    public function index(Request $request)
    {
        //查询数据
        $data = DB::table('cooperation') -> paginate(10);
        foreach($data as $k => $v)
        {
            $v -> created_at = date('Y-m-d H:i:s',$v -> created_at);
            $v -> updated_at = date('Y-m-d H:i:s',$v -> updated_at);

        }
        return view('admin.partner.partnerList',['data' => $data,'request' => $request -> all()]);
    }

    //合作商家添加页面
    public function add()
    {
        return view('admin.partner.partnerAdd');
    }

    //执行添加
    public function insert(Request $request)
    {
        $data = $request -> except('_token','s');
        //处理图片
        if($request -> hasFile('pic'))
        {
            if($request -> file('pic') -> isValid())
            {
                //获取图片扩展名
                $extension = $request -> file('pic') -> getClientOriginalExtension();
                //拼接图片名称
                $fileName = str_random(30).'.'.$extension;
                $dir = './uploads/product/cate/';
                //判断目录是否存在
                if(!file_exists($dir))
                {
                    mkdir($dir,0777,true);
                }
                //移动
                $move = $request -> file('pic') -> move($dir,$fileName);
                //判断是否移动成功
                if($move)
                {
                    $data['pic'] = $fileName;
                }
            }
        }else{
            return back()->with(['info'=>'请上传图片']);
        }
        //准备数据
        $data['created_at'] = time();
        $data['updated_at'] = time();
        if(empty($data['url'])){
            $data['url'] = '';
        }
        $data['clert'] = Session('admin') ? Session('admin') : 0;
        //更新数据库
        $res = DB::table('cooperation')  -> insert($data);
        if($res)
        {
            return redirect('admin/partner/partnerList');
        }else
        {
            return back()-> with(['info' => '添加失败']);
        }
    }

    //修改页面
    public function change($id)
    {
        $data = DB::table('cooperation') -> where('id',$id) -> first();
        return view('admin.partner.partnerChange',['data' => $data]);
    }

    //执行修改
    public function update(Request $request,$id)
    {
        //数据处理
        $this -> validate($request,[
            'name' => 'max:45',
        ],[
            'name.max' => '合作商家名称过长',
        ]);
        $data = $request -> except('_token','s');
        $oldPic = DB::table('cooperation') -> where('id',$id) -> value('pic');
        if($oldPic)
        {
            //处理图片
            if($request -> hasFile('pic'))
            {
                if($request -> file('pic') -> isValid())
                {
                    //获取图片扩展名
                    $extension = $request -> file('pic') -> getClientOriginalExtension();
                    //拼接图片名称
                    $fileName = str_random(30).'.'.$extension;
                    $dir = './uploads/product/cate/';
                    //判断目录是否存在
                    if(!file_exists($dir))
                    {
                        mkdir($dir,0777,true);
                    }
                    //移动
                    $move = $request -> file('pic') -> move($dir,$fileName);
                    //判断是否移动成功
                    if($move)
                    {
                        $data['pic'] = $fileName;
                    }
                }
            }else{
                $data['pic'] = $oldPic;
            }
        }
        //准备数据
        $data['updated_at'] = time();
        $data['clert'] = Session('admin') ? Session('admin') : 0;
        //查询原来的图片名称
        $pic = DB::table('cooperation') -> select('pic')-> where('id',$id) -> get();
       //删除原来的图片
//        Storage::delete($pic);

        $res = DB::table('cooperation') -> where('id',$id) -> update(['name'=> $data['name'],'pic'=>$data['pic'],'updated_at'=>$data['updated_at'],'clert'=>$data['clert'],'url' => $data['url']]);
        if($res)
        {
            return redirect('admin/partner/partnerList') -> with(['info' => '更新成功']);
        }else
        {
            return back() -> with(['info' => '更新失败']);
        }
    }

    //删除合作商家
    public function delete($id)
    {
        //删除所选管理员
    	$res = DB::table('cooperation') -> delete($id);
    	//判断操作是否成功
        if($res)
        {
            return redirect('admin/partner/partnerList') -> with(['info' => '删除成功']);
        }else
        {
            return back() -> with(['info' => '删除失败']);
        }
    }

}
