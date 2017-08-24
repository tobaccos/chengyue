<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Hash;

class AdminController extends CommonController
{
    //管理员添加页面
    public function add()
    {
		//查询管理员组
		$data = DB::table('group') -> get();
    	return view('admin.admin.adminAdd',['data' => $data]);
    }

    //执行添加管理员操作
    public function insert(Request $request)
    {
    	//数据验证
    	$this -> validate($request,[
    		'name' => 'min:1|max:25',
    		'password' => 'required',
    		'email' => 'email|unique:admin',
    		],[
    		'name.min' => '用户名不能小于1个字符',
    		'name.max' => '用户名不能大于25个字符',
    		'password.required' => '密码不能为空',
    		'email.email' => '邮箱格式不合法',
            'email.unique' => '该邮箱已被注册',
    		]);
    	$data = $request -> except('_token','s');
    	//密码加密
    	$password = Hash::make($data['password']);
    	$data['password'] = $password;
		$data['created_at'] = time();
		$data['updated_at'] = time();

    	//将数据插入数据表
    	$res = DB::table('admin') -> insert([
    		'name' => $data['name'],
    		'password' => $data['password'],
    		'email' => $data['email'],
			'created_at' => $data['created_at'],
			'updated_at' => $data['updated_at'],
			'group_id' => $data['group_id'],
    		]);
    	//判断操作是否成功
    	if($res)
    	{
    		return redirect('admin/admin/adminList') -> with(['info' => '添加成功']);
    	}else
    	{
    		return back() -> with(['info' => '添加失败']);
    	}
    }

    //管理员列表页
    public function index(Request $request)
    {
    	//查询数据
    	$data = DB::table('admin') ->paginate(10);
        foreach ($data as $key => $value) {
            $value -> gName = DB::table('group') -> where('id',$value -> group_id) -> value('name');
        }
		foreach($data as $k => $v)
		{
			$v -> created_at = date('Y-m-d H:i:s',$v -> created_at);
			$v -> updated_at = date('Y-m-d H:i:s',$v -> updated_at);

		}
    	return view('admin.admin.adminList',['data' => $data,'request' => $request -> all()
		]);
    }

    //管理员修改页
    public function edit($id)
    {
    	//查询数据
    	$data = DB::table('admin') -> where('id',$id) -> first();
    	//管理员组
        $res = DB::table('group') ->select('id','name') ->get();
    	return view('admin.admin.adminChange',['data' => $data,'res' =>$res]);
    }

    //update
    public function update(Request $request,$id)
    {
    	//数据验证
    	$this -> validate($request,[
            'name' => 'min:2|max:18',
            'password' => 'required',
            'email' => 'email',
            ],[
            'name.min' => '用户名不能小于2个字符',
            'name.max' => '用户名不能大于18个字符',
            'password.required' => '密码不能为空',
            'email.email' => '邮箱格式不合法',
            ]);

        $data = $request -> except('_token','repassword','s');
		$data['created_at']=time();
		$data['updated_at']=time();
//		var_dump($data);die;
        //密码加密
        $data['password'] = Hash::make($data['password']);
        //更新数据表
        $res = DB::table('admin') -> where('id',$id) -> update($data);
        //判断操作是否成功
        if($res)
        {
           return redirect('admin/admin/adminList') -> with(['info' => '更新成功']);
        }else
        {
            return redirect('admin/admin/adminList') -> with(['info' => '更新失败']);
        }
    }

    //管理员删除
    public function delete($id)
    {
    	//删除所选管理员
    	$res = DB::table('admin') -> delete($id);
    	//判断操作是否成功
        if($res)
        {
            return '删除成功';
        }else
        {
            return '删除失败';
        }

    }

	//状态修改
	public function state($id)
	{
		//查询所选管理员信息
		$data = DB::table('admin') -> where('id',$id) -> first();
		if($data -> state == 0)
		{
            $state = 1;

		}elseif($data -> state == 1)
		{
            $state = 0;
		}

		//更新数据表
		$res = DB::table('admin') -> where('id',$id) -> update(['state' => $state]);
		//判断操作是否成功
		if($res)
		{
			return redirect('admin/admin/adminList') -> with(['info' => '更新成功']);
		}else
		{
			return redirect('admin/admin/adminList') -> with(['info' => '更新失败']);
		}
	}

	//节点列表
	public function nodeList(Request $request)
	{
		//查询数据
		$data = DB::table('rules') -> select('id','name') -> where('father_id','>',0) -> paginate(10);
		return view('admin.admin.nodeList',['data' => $data,'request' => $request -> all()]);
	}


	//添加节点
	public function nodeAdd(Request $request)
	{
		//判断是否为post提交
		if($request -> isMethod('post'))
		{
			//处理数据
			$data = $request -> except("_token");
			$res = DB::table('rules') -> insert($data);
			if($res)
			{
				return redirect('admin/admin/nodeList')-> with(['info' =>'添加成功']);
				die;
			}else{
				return back() -> with(['info' => '添加失败']);
			}

		}
		$data = DB::table('rules')  -> get();
		return view('admin.admin.nodeAdd',['data' => $data]);
	}

	//修改节点
	public function nodeUpdate($id)
	{
		//节点组的数据
		$data = DB::table('rules')  -> get();
		//查询出该节点的数据
		$res = DB::table('rules') -> where('id',$id) -> first();
		return view('admin.admin.nodeChange',['data' => $data,'res' => $res]);
	}

	//删除节点
	public function nodeDel()
	{
		$id = $_GET;
		$res = DB::table('rules') -> delete($id);
		if($res)
		{
			echo '删除成功';
		}else
		{
			echo '删除失败';
		}
	}

	//执行修改
	public function nodeEdit(Request $request,$id)
	{
		//处理数据
		$data = $request -> except("_token",'s');
		$res = DB::table('rules') -> where('id',$id) -> update($data);
		if($res)
		{
			return redirect('admin/admin/nodeList')-> with(['info' =>'修改成功']);
			die;
		}else{
			return back() -> with(['info' => '添加失败']);
		}
	}

	//分组管理
	public function groups()
	{
		//查询权限
		$data = DB::table('group')-> get();
		return view('admin.admin.groups',['data' => $data]);
	}


	//添加分组
	public function userGroup()
	{
		//查询权限
		$data = DB::table('rules') -> where('father_id',0)-> get();
		$res = DB::table('rules') -> where('father_id','>',0)-> get();
		return view('admin.admin.userGroup',['data' => $data,'res' =>$res]);
	}

	//执行添加
	public function groupAdd()
	{
		//处理数据
		$name = $_POST['name'];
        if(empty($_POST['ids']))
        {
          echo '请选择分组下所有权限';
          die;
        }
        $ids = $_POST['ids'];
        $roles = implode(",",$ids);
        //执行添加
        $res = DB::table('group') -> insert(['name'=>$name,'roles' => $roles]);
        if($res)
        {
            echo '添加成功';
        }else
        {
            echo '添加失败';
        }
	}

	//查看权限
	public function show()
	{
        $id = $_GET;
        //查询
        $data = DB::table('group') -> select('roles') -> where('id',$id) -> first();
        $roles = explode(',',$data -> roles);
        $name = array();
        foreach ($roles as $v) {
            $rules = DB::table('rules') -> select('name') -> where('id',$v) -> first();
            $name[] = $rules -> name;
       }
       return array_values($name);
	}
public function groupChange($id)
{
  //查询权限
  $data = DB::table('rules') -> where('father_id',0)-> get();
  $res = DB::table('rules') -> where('father_id','>',0)-> get();
  //查看此分组的权限
  $meg = DB::table('group')-> select('id','name','roles') -> where('id',$id) -> first();
  $roles=explode(',',$meg-> roles);
  return view('admin.admin.groupChange',['data' => $data,'res' =>$res,'roles' =>$roles,'meg'=>$meg]);

  }

  //执行修改
    public function groupEdit()
    {
        //处理数据
        if(empty($_POST['ids']))
        {
          echo '请勾选分组下所有权限';
          die;
        }
        $name = $_POST['name'];
        $ids = $_POST['ids'];
        $roles = implode(",",$ids);
        //执行修改
        $res = DB::table('group') ->where('id',$_POST['id'])-> update(['name'=>$name,'roles' => $roles]);
        if($res)
        {
            echo '修改成功';
        }else
        {
            echo '修改失败';
        }
    }

    //分组删除
    public function groupDel()
    {
       //判断该分组下是否有管理员
        $data = DB::table('admin') -> where('group_id',$_GET['id']) ->first();
        if(empty($data))
        {
            //执行删除
            $res = DB::table('group')->where('id',$_GET['id']) ->delete();
            if($res)
            {
                echo "删除成功";
            }else{
                echo "删除失败";
            }

        }else{
            echo "该分组下有管理员，不能删除分组";
        }
    }
}
