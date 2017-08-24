<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use QrCode;

class AgencyController extends CommonController
{
    //申请列表
    public function index(Request $request)
    {
        $keyword = $request -> input('keyword');
    	$data = DB::table('users')
    				-> join('user_info','users.id','=','user_info.user_id')
    				-> select('users.id','users.name','users.phone','users.email','user_info.dls_apply','user_info.join_address','user_info.content','users.updated_at')
    				-> where('user_info.dls_apply','>','0')
                    -> whereRaw('instr(name, \''. $keyword .'\') > 0')
    				-> paginate(10);
        foreach($data as $k => $v)
        {
            $v -> updated_at = date('Y-m-d H:i:s',$v -> updated_at);

        }
    				// var_dump($data);die;
    	return view('admin/user/agency/agencyList',['data' => $data,'request' => $request -> all()
		]);
    }

    //通过申请
    public function adpot($id)
    {
    	$data = DB::table('user_info') -> where('user_id',$id) -> first();
    	if($data -> dls_apply == 1 ||$data -> dls_apply ==3 )
    	{
			//二维码
			QrCode::format('png')->size(200)->generate('http://www.youpinshanglian.com/register?par='.$id,public_path('home/code/'.$id.'.png'));
			$code = $id.'.png';
			$tdata = 2;
			//更新数据
			$res = DB::table('user_info') -> where('user_id',$id) -> update(['dls_apply' => $tdata,'code'=>$code]);
			$r = DB::table('users') -> where('id',$id) -> update(['usertype' => 1]);
			if($res)
			{
				return redirect('admin/user/agency/agencyList') ->with(['info' => '已审核通过']);
			}else
			{
				return back() -> with(['info' => '请查看用户的详细信息']);
			}
    	}else
    	{
    		return redirect('admin/user/agency/agencyList') -> with(['info' => '请查看用户的详细信息']);
    	}

    }

    //驳回申请
    public function reject(Request $require,$id)
    {
    	$data = DB::table('user_info') -> where('user_id',$id) -> first();
    	if($data -> dls_apply == 1 )
    	{
    		$tdata = 3;
			//准备数据
			$pdata = $require -> except('_token','s');
			//更新数据
			$res = DB::table('user_info') -> where('user_id',$id) -> update(['dls_apply' => $tdata,'content' => $pdata['content']]);
			if($res)
			{
				return redirect('admin/user/agency/agencyList') ->with(['info' => '驳回审核']);
			}else
			{
				return back() -> with(['info' => '驳回失败，请查看用户的详细信息']);
			}
    	}else
    	{
    		return redirect('admin/user/agency/agencyList') -> with(['info' => '请查看用户的详细信息']);
    	}


    }

    //取消代理商
    public function cancel($id)
    {
    	//更新数据
    	$res = DB::table('user_info') -> where('user_id',$id) -> update(['dls_apply' => 0,'code'=>'default.jpg']);
    	if($res)
    	{
            DB::table('users') -> where('id',$id) -> update(['usertype' => '0']);
    	    $image = public_path("home/code/") .$id.".png";
            //删除图片
            unlink($image);
    		echo '取消成功';
    	}else
    	{
    		echo  '取消失败';
    	}
    }

	//查看原因
	public function show()
	{
		$id = $_GET;
		//查询数据
		$data = DB::table('user_info')-> select('content')-> where('user_id',$id)-> first();
		$content = $data->content;
		echo $content;
	}

}
