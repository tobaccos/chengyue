<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Hash;


class UserController extends CommonController
{
    //列表页
    public function index(Request $request)
    {
    	//查询用户数据
		//判断是否有起止时间\
		if($request -> input('start',''))
		{
			$start = strtotime($request -> input('start',''));
		}else
		{
			$start = 0;
		}
		if($request -> input('end',''))
		{
			$end = strtotime($request -> input('end',''));
		}else
		{
			$end = time();
		}
		$keywords = $request -> input('keywords');

		$data = DB::table('users')
     -> whereRaw('instr(name, \''. $keywords .'\') > 0')
     -> whereBetween('created_at',[$start,$end])
     -> paginate(10);
		foreach ($data as $k => $v) {
			$v -> tname = DB::table('user_type') -> where('id',$v -> usertype) -> value('name');

			$v -> created_at = date('Y-m-d H:i:s',$v -> created_at);
//			$v -> updated_at = date('Y-m-d H:i:s',$v -> updated_at);
			$v->pay_amount = DB::table("orders")->select("pay_amount")->where("user_id",$v->id)->sum("pay_amount");

		}

		return view('admin/user/usermessage/userList',['data' => $data,'request' => $request -> all()]);
    }

    //状态修改
	public function state($id)
	{
		//查询所选管理员信息
		$data = DB::table('users') -> where('id',$id) -> first();
		if($data -> state == 0)
		{
			$state = 1;
		}elseif($data -> state == 1)
		{
            $state = 0;
		}

		//更新数据表
		$res = DB::table('users') -> where('id',$id) -> update(['state' => $state]);
		//判断操作是否成功
		if($res)
		{
			return redirect('admin/user/usermessage/userList') -> with(['info' => '更新成功']);
		}else
		{
			return redirect('admin/user/usermessage/userList') -> with(['info' => '更新失败']);
		}
	}

	//修改页面
	public function change($id)
	{
		//查询该条数据
		$data = DB::table('users')
                    -> join('user_type','users.usertype','=','user_type.id')
                    -> join('user_info','users.id','=','user_info.user_id')
                    -> select('users.id','users.name','users.state','user_type.id as tid','user_type.name as tname','users.phone','users.email','user_info.QQ','user_info.dls_apply')
                    -> where('users.id',$id)
                    -> get();
        //查询所有用户类型
        $tdata = DB::table('user_type') -> select('id','name') -> get();
		return view('admin/user/usermessage/userChange',['data' => $data,'tdata' => $tdata]);
	}

    //执行修改
    public function update(Request $request,$id)
    {
        //开启事务
        DB::beginTransaction();
        try{
			//处理接受的数据
			$data = $request -> except('_token','s');
			$data['updated_at'] = time();
			// var_dump($data);die;
            $users = DB::table('users') -> where('id',$id)->update(['name' => $data['name'], 'usertype' => $data ['tid'], 'state' => $data['state'], 'email' => $data ['email'], 'phone' => $data['phone'],'updated_at' => $data['updated_at']]);

			$user_info = DB::table('user_info') -> where('user_id',$id) -> update(['QQ' => $data['QQ']]);
			DB::commit();
			if($users || $user_info)
			{
				return redirect('admin/user/usermessage/userList') -> with(['info' => '修改成功']);
			}else{
				return back() -> with(['info' => '修改失败']);
			}
        }catch (\Exception $e) {
            DB::rollBack();
            return back() -> with(['info' => '请重试']);
        }
    }

	//查看详情
	public function detail($id)
	{
		//查看数据
		$users = DB::table('users')											//用户表数据
					-> join('user_info as ui','users.id','=','ui.user_id')	//用户详情表数据
					-> join('user_type','users.usertype','=','user_type.id')
					-> select('users.name','users.state','users.email','users.phone','users.created_at','ui.QQ','ui.dls_apply','user_type.name as tname','ui.virtualcurrency')
					//用户分成表数据
					-> where('users.id',$id)
					-> get();
		//处理时间
		foreach($users as $k => $v)
		{
			$v -> created_at = date('Y-m-d H:i:s',$v -> created_at);
		}

		//推广总人数
		$num = DB::table('users') -> where('father_id',$id) -> count();
		// var_dump($num);die;
		$data = array();
		if($num >0)
		{
			//分销数据
			$ids = array();
			$ids = DB::table('rebate_log') -> select('buy_user_id')-> where('user_id',$id) -> get();
			// 实验写法
			// $ids = DB::table('rebate_log')-> where('user_id',$id) -> pluck('buy_user_id');
			// var_dump($ids);die;
			foreach ($ids as $key => $value) {
				//查询用户数据
				$data = DB::table('users')
					-> join('user_type','users.usertype','=','user_type.id')
					-> join('user_info','users.id','=','user_info.user_id')
					-> select('users.id','users.created_at','user_type.name as tname','users.updated_at','users.state','users.name as username','users.email')
					-> where('users.id',$value-> buy_user_id)
					-> get();
//					 var_dump($data);die;
				//处理时间,总金额
				foreach($data as $k => $v)
				{
					$v -> created_at = date('Y-m-d H:i:s',$v -> created_at);
					$v -> updated_at = date('Y-m-d H:i:s',$v -> updated_at);
					//商品总价
					$v->pay_amount = DB::table("orders")->select("pay_amount")->where("user_id",$v->id)->sum("pay_amount");
					//订单数量
					$v->count = DB::table("orders")->where("user_id",$v->id)->count();
					//产品名称
					$v->pname = DB::table('orders')
						-> join('product','orders.pro_id','=','product.id')
						-> select('product.name','orders.addtime','orders.pay_amount')
						-> where('orders.user_id',$v -> id)
						-> get();
				}
			}
		}
		return view('admin.user.usermessage.userDetail',['users' => $users,'num' => $num,'data' => $data]);

	}

	//用户删除
	public function delete()
	{
		$id = $_GET['id'];
		//查询是否有为完成的订单数据
		$res = DB::table('users')
				-> join('orders','orders.user_id','=','users.id')
				-> where('users.id',$id)
				-> where('orders.order_status','<','4')
				-> get();
		if(!$res->isEmpty())
		{
			echo  '该用户有未完成的订单,无法删除';
			die;
		}
		//判断是否有下线用户
		$res1 = DB::table('users') -> where('father_id',$id) -> get();
		if(!$res1->isEmpty())
		{
			echo  '该用户有下线用户,无法删除';
			die;
		}
		//执行删除
		DB::beginTransaction();		//开启事物
		try{
			//删除该用户下所有订单数据
			$r1 = DB::table('orders') -> where('user_id',$id) -> get();
			foreach($r1 as $v)
			{
				$ri = DB::table('orserinfo') -> where('order_sn',$v -> order_sn) -> delete();
			}
			$or = DB::table('orders') -> where('user_id',$id) -> delete();

			//删除评论信息
			$r2 =  DB::table('comment') -> where('user_id',$id) -> delete();
			//删除分成记录
			$r3 = DB::table('rebate_log') -> where('user_id',$id) -> delete();
			//删除提现记录
			$r4 = DB::table('user_account')-> where('user_id',$id) -> delete();
			//删除充值记录
			$r5 = DB::table('rechange')-> where('user_id',$id) -> delete();
			//删除地址记录
			$r6 = DB::table('user_address')-> where('user_id',$id) -> delete();
			//
			$r6 = DB::table('user_account')-> where('user_id',$id) -> delete();
			//修改该用户下线的父级id
			$r7 = DB::table('users') -> where('father_id',$id) -> update(['father_id' => 0]);
			//删除用户基本信息
			$r8 = DB::table('user_info')-> where('user_id',$id) -> delete();
			$r9 = DB::table('users')-> where('id',$id) -> delete();
			DB::commit();
			echo  '删除成功';
		}catch (\Exception $e) {
			DB::rollBack();
			echo  '请重试';
		}

	}

	//充值记录
	public function recharge(Request $request)
	{
			//获取信息
			$data = DB::table('rechange')
				-> join('users','rechange.user_id','=','users.id')
				-> select('users.name','rechange.money','rechange.created_at','rechange.recharge_sn','rechange.id')
				-> where('rechange.state','1')
			  -> paginate(10);

			  //处理时间戳
			  foreach ($data as $v) {
			  	$v -> created_at = date('Y-m-d H:i:s',$v -> created_at);
			  }
			return view('admin.user.application.recharge',['data' => $data,'request' => $request -> all()]);
	}

	//删除所有充值记录
	public function del()
	{
		$res = DB::table('rechange')->truncate();
		echo '删除成功';
	}

  //重置密码
  public function reset()
  {
    $id = $_GET['id'];

    $password = Hash::make('123456');
    $res = DB::table('users') -> where('id',$id) -> update(['password' => $password]);
    if($res)
    {
      echo '密码重置成功';
    }else{
      echo '密码重置失败';
    }
  }

}
