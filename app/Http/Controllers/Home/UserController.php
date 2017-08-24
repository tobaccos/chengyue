<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use DB;
use Hash;

class UserController extends Controller
{
	


    /*
     * 个人中心
     */
    public function index ($status=false)
    {
//        $status = '1';
        $userId = Auth::id();
//        var_dump($userId);die;
        //如果是新注册用户,在user_info中添加信息
        $res = DB::table('user_info') -> select('user_id') -> where('user_id',$userId) -> get() -> toArray();
//        var_dump($res);die;
        if(!$userId)
        {
            return redirect('/login');
        }
        if(empty($res))
        {
            //添加
             DB::table('user_info') -> insert(['user_id'=> $userId]);
        }
        // 用户信息
        $data = DB::table('users')
            ->where('id',$userId)
            ->leftJoin('user_info','users.id','=','user_info.user_id')
            ->first();

        //收藏
        $collection =  DB::table('user_collection')
            ->where('user_id',$userId)
            ->leftjoin('product','product.id','=','user_collection.user_id')
            ->get();
        // 订单
        $order = DB::table('orders')
            ->when($status,function ($query) use ($status){
                return $query -> where('order_status',$status);
            })
            ->where('user_id',$userId)
            ->get();
        // 未付款
        $weifu = DB::table('orders')
            ->where([
                ['order_status',0],
                ['user_id',$userId],
            ])
            ->whereNotIn('table_type', [0])
            ->get();
        // 待制作
        $weizuo = DB::table('orders')
            ->where([
                ['order_status',1],
                ['user_id',$userId],
                ['is_delete',0]
            ])
            ->whereNotIn('table_type', [0])
            ->get();

        // 待发货
        $weifa = DB::table('orders')
            ->where([
                ['order_status',2],
                ['user_id',$userId],
                ['is_delete',0]
            ])
            ->whereNotIn('table_type', [0])
            ->get();
        // 已发货
        $fahuo = DB::table('orders')
            ->where([
                ['order_status',3],
                ['user_id',$userId],
                ['is_delete',0]
            ])
            ->whereNotIn('table_type', [0])
            ->get();
        // 已收货
        $shou = DB::table('orders')
            ->where([
                ['order_status',4],
                ['user_id',$userId],
                ['is_delete',0]
            ])
            ->whereNotIn('table_type', [0])
            ->get();

        $order['weifu'] = count($weifu);
        $order['weizuo'] = count($weizuo);
        $order['weifa'] = count($weifa);
        $order['fahuo'] = count($fahuo);
        $order['shou'] = count($shou);
        $order['weifa'] = $order['weizuo'] + $order['weifa'];
        // 分销
        $rebate = DB::table('rebate_log')
            ->where([
                ['is_delete',0],
                ['user_id',$userId]
            ])
            ->get();
//dd($data);
        return view('home.member.myInfo',['data'=>$data,'collection'=> $collection,'order'=> $order,'rebate'=>$rebate]);
    }


    /*
     * 用户上传头像
     */
    public function uploadImage (Request $request)
    {
//        dd($request->all());
        $file = $request->file('myFile');

        $userId = Auth::id();

        if($file && $file->isValid()){
            $originalName = $file->getClientOriginalName();     // 文件原名 3.jpg
            $extension = $file->getClientOriginalExtension();   // 扩展名 jpg
            $allow_extensions = ['jpg','png','jpeg',];
            if($originalName && !in_array($extension,$allow_extensions))
            {
                return back() ->with(['info','上传格式错误']);
            }

            $newName = date('YmdHis').mt_rand(1000,9999).".".$extension;
            $path = $file->move(base_path()."/public/uploads/user",$newName);
            if(!$path){
                return back() ->with(['info','上传失败']);
            }
            $filepath = 'public/uploads/user/'.$newName;
//            return $filepath;

        }
        $user_img = DB::table('user_info')->where('user_id',$userId)->select('pic')->first();


        $res = DB::table('user_info')->where('user_id',$userId)->update(['pic'=> $newName]);

        if($res)
        {
            return "上传成功";
        }else{
            return "上传失败";
        }
    }


    /*
     * 管理收货地址
     */

    public function address (Request $request)
    {


//        $default = $request->get('default');
//        $id = $request->get('id');


        $userId = Auth::id();
        $address = DB::table('user_address')
            ->where('user_id',$userId)
            ->get();

        foreach ($address as $key => $value) {
            // 省
            $provice = $value->address1 ? $value->address1 : "";
            // 市
            $city = $value->address2 ? $value->address2 : "";
            // 县
            $county = $value->address3 ? $value->address3 : "";
            // 乡
            $town = $value->address4 ? $value->address4 : "";
            // 村
            $village = $value->address5? $value->address5 : "";
            // 详细地址
            $detail = $value->address_details ? $value->address_details : "";
            // 拼接地址
            $data = $provice.$city.$county.$town.$village.$detail;
            $address[$key]->address = $data;

        }




//dd($address);
        return view('home.member.address',['data'=>$address]);
    }


    /*
    * 编辑地址
    */
    public function addressEdite(Request $request)
    {
//        dd($request->only('id'));
        $id = $request->get('id') ;
        $userId = Auth::id();
        $address = DB::table('user_address')
            ->where([
                ['user_id',$userId],
                ['id',$id]
            ])
            ->first();
//dd($address);
        return view ('home.member.addressEdite',['data' => $address]);

    }
	
    /*
     * 管理收货地址
     */

    public function payAddress (Request $request)
    {


//        $default = $request->get('default');
//        $id = $request->get('id');


        $userId = Auth::id();
        $address = DB::table('user_address')
            ->where('user_id',$userId)
            ->get();

        foreach ($address as $key => $value) {
            // 省
            $provice = $value->address1 ? $value->address1 : "";
            // 市
            $city = $value->address2 ? $value->address2 : "";
            // 县
            $county = $value->address3 ? $value->address3 : "";
            // 乡
            $town = $value->address4 ? $value->address4 : "";
            // 村
            $village = $value->address5? $value->address5 : "";
            // 详细地址
            $detail = $value->address_details ? $value->address_details : "";
            // 拼接地址
            $data = $provice.$city.$county.$town.$village.$detail;
            $address[$key]->address = $data;

        }




//dd($address);
        return view('home.shopping.payAddress',['data'=>$address]);
    }

    /*
     * 默认地址
     */
    public function default(Request $request)
    {
        $userId = Auth::id();
        $id = $request -> get('id');
        //设置默认地址
        if($request->get('state') ==  1)
        {
            $update = DB::table('user_address')
                ->select('is_default','id')
                ->where([
                    ['user_id',$userId],
                    ['state',0]
                ])
                ->update(['is_default'=> '0']);

            $res = DB::table('user_address')
                ->where([
                    ['user_id',$userId],
                    ['state',0],
                    ['id',$id]
                ])
                ->update(['is_default'=> 1]);
            return $res ? "200" : "404";

        }
    }


    /*
     * 删除地址
     */
    public function delete (Request $request)
    {
        $userId = Auth::id();
        $id = $request->get('id');
        $res = DB::table('user_address')
                        ->where([
                            ['user_id',$userId],
                            ['id',$id]
                        ])
                        ->delete();
        if($res)
        {
            return response() ->json(['200'=> "删除成功"]);
        }else{
            return response() -> json(['404' => "删除失败"]);
        }

    }



    /*
     * 修改地址
     */
    public function update(Request $request)
    {
        $userId = Auth::id();
        $id = $request->get('id');

        //修改地址
        DB::table('user_address')
            ->where([
                ['user_id',$userId],
                ['id',$id]
            ])
            ->update([
                'address_details'=>$request->get('detail'),
                'name'=>$request->get('name'),
                'phone'=>$request->get('tel'),
                'address1'=>$request->get('province'),
                'address2'=>$request->get('city'),
                'address3'=>$request->get('district'),
            ]);

        $data = DB::table('user_address')
            ->where([
                ['user_id',$userId],
            ])
            ->get();

        return $data ? "200" : "404";
//        return view('home.member.address',['data'=> $data]);
    }

    //添加收货地址
    public function addressAdd(Request $request)
    {
        //判断路径类型是否为post
        if($request -> isMethod('post'))
        {
            $userId = Auth::id();
            //处理数据
            $data = $request -> except('_token');
            $data['created_at'] = time();
            $data['updated_at'] = time();
            $data['is_default'] = 1;
            DB::table('user_address')->where('user_id',$userId)->update(['is_default'=> 0]);
            //执行添加
            $res = DB::table('user_address') -> insert([
                        'user_id' => $userId,
                        'name'=>$data['user'],
                        'address1' => $data['province'],
                        'address2' => $data['city'],
                        'address3' => $data['district'],
                        'address_details' => $data['detail'],
                        'phone' => $data['tel'],
                        'created_at' => $data['created_at'],
                        'updated_at' => $data['updated_at'],
                        'is_default' => $data['is_default'],
                 ]);
//            echo '11'; die;
            if($res)
            {
                return '添加成功';
				die;
            }else{
                return '添加失败';
				die;
            }
            die;
        }

        return view('/home/member/addressAdd');
    }

    /*
     * 个人信息
     */
    public function personal()
    {
        $userId = Auth::id();
//        var_dump($userId);die;
        $data = DB::table('users')
            ->join('user_info','user_info.user_id','=','users.id')
            ->where([
                ['users.id',$userId]
            ])
            ->first();
//        var_dump($data);die;
        return view('home.member.personal',['data'=>$data]);
    }



    /**
     * 查看充值记录
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @method  get
     */
    public function recharge(Request $request)
    {
        $user_id = Auth::id();

		if($request -> isMethod('post')){
			//查询起始金额
            $ltime = strtotime($request->get('ltime'));
            $ftime = strtotime($request->get('ftime'));
			$ltime += 86390; 
			
            $userId = Auth::id();
            //充值总额
            $money = DB::table('rechange')
                ->select(DB::raw('sum(money) as money '))
                ->where([
                    ['user_id',$userId],
                    ['state',1]
                ])
                ->first();

            //分页输出
            $data = DB::table('rechange')
                ->join('users','users.id','=','rechange.user_id')
                ->when($ftime,function ($query) use ($ftime,$ltime){
                    return $query->whereBetween('rechange.created_at',[$ftime,$ltime]);
                })
                ->where([
                    ['rechange.user_id',$userId],
                    ['rechange.state',1]
                ])
                ->select('users.name','rechange.*')
                ->get();
			
            $totalMoney = 0;
            foreach ($data as $value) {
                $totalMoney +=  $value->money;
            }
            $data->totalMoney = $totalMoney;
			
			      $str = '';
            foreach ($data as $value){
                $str .= '<tr>
                    <input type="hidden" class="del" value='.$value->id.' />
                    <td class="td">'.$value->name.'</td>
                    <td>'.date("Y-m-d" ,$value-> created_at).' </td>
                    <td class="pos td">'.$value->money.'</td>
                    
                </tr>';
            }
            return response() -> json($str);
		}

		//查询起始金额
            $ltime = strtotime($request->get('ltime'));
            $ftime = strtotime($request->get('ftime'));

            $userId = Auth::id();
            //充值总额
            $money = DB::table('rechange')
                ->select(DB::raw('sum(money) as money '))
                ->where([
                    ['user_id',$userId],
                    ['state',1]
                ])
                ->first();

            //分页输出
            $data = DB::table('rechange')
                ->join('users','users.id','=','rechange.user_id')
                ->where([
                    ['rechange.user_id',$userId],
                    ['rechange.state',1]
                ])
                ->select('users.name','rechange.*')
                ->get();
			
            $totalMoney = 0;
            foreach ($data as $value) {
                $totalMoney +=  $value->money;
            }
            $data->totalMoney = $totalMoney;
			
            
            return view('home.member.recharge',['data'=>$data,'totalMoney'=>$money]);


    }


    /*
     * 代理商申请
     */
    public function dls_apply(Request $request)
    {
        $userId = Auth::id();
//        $input = $request -> except('_token','s');
        $res = DB::table('user_info')
            ->where('user_id',$userId)
            ->select('dls_apply')
            ->first();
        //判断是否符合条件
        switch ($res->dls_apply)
        {
            case  0:
                $res1 = DB::table('user_info')
                    ->where([
                        ['user_id',$userId],
                        ['dls_apply',0]
                    ])
                    ->update(['dls_apply' => 1]);
                return $res1 ? "申请成功" : "申请失败";
            case 1:
                return "正在申请中";
            case 2:
                return "申请已通过";
            case 3:
                return "申请为通过";

        }
    }

    //修改密码
    public function passUpdate(Request $request)
    {
        $data = $request -> except('_token');
        //用户ID
        $userId = Auth::id();
        //查询数据
        $res = DB::table('users') -> where('id',$userId) -> first();
//        var_dump($data['oldPass']);die;
        //判断原密码是否正确
        $r = Hash::check($data['oldpwd'],$res -> password);
        if(!$r)
        {
            return '404';
        }
        //密码加密
        $password = Hash::make($data['pwd']);
        //执行修改
        $res = DB::table('users') -> where('id',$userId)-> update(['password' => $password]);
        if($res)
        {
            return  '200';
        }else
        {
            return  '404';
        }
     }


    //代理商申请
    public function areaApp(Request $request)
    {
        //判断是否为post提交
        if($request -> isMethod('post'))
         {
            //获取用户id
            $userId = Auth::id();
            //接受数据
            $data = $request -> except('_token','s');
            //拼接加盟区域
            $address = $data['province'].$data['city'].$data['district'].$data['detail'];
            //修改状态
            $res = DB::table('user_info') -> where('user_id',$userId) -> update(['dls_apply' => 1,'join_address' => $address]);
            if($res)
            {
                return '申请成功';
            }else
            {
                return "申请失败";
            }
        }
        return view('/home/member/areaApp');
    }


    /*
     * 个人中心设置
     * 5月10号
     */
    public function set()
    {
        $user_id = Auth::id();
        $data = DB::table('user_info')->where('user_id',$user_id)->first();
        return view('home.member.set',['data' => $data]);
    }

    /*
     * 绑定邮箱
     */
    public function email(Request $request)
    {
        $input = $request -> get('email');
        $user_id = Auth::id();
        $users = DB::table('users')
            ->whereIn('email',[$input])
            ->get();
        if(count($users) > 0){
            return back()->with(['email'=> '邮箱已存在！']);
        }
        $res = DB::table('users')->where('id',$user_id)->update(['email'=> $input]);
        if($res){
            return back();
        }else{
            return back();
        }
    }

    /**
     * @param Request $request
     */
    public function phone(Request $request)
    {
        $input = $request -> get('phone');
        $user_id = Auth::id();

       $users = DB::table('users')
                   ->whereIn('phone',[$input])
                   ->get();

       if(count($users) > 0){
           return back()->with(['phone'=> '手机已存在！']);
       }
        $res = DB::table('users')->where('id',$user_id)->update(['phone'=> $input]);
        if($res){
            return back();
        }else{
            return back();
        }
    }

    /*
     * 添加QQ号
     */
    public function QQ_add(Request $request)
    {
        $input = $request -> get('qq');
        $user_id = Auth::id();
        $res = DB::table('user_info')->where('user_id',$user_id)->update(['QQ'=> $input]);
        if($res)
        {
            return back();
        }else{
            return back();
        }
    }

    /**
     * @param Request $request
     * 修改用户昵称
     */
    public function userNameUpdate(Request $request)
    {
        $name = $request->only('name');
        $user_id = Auth::id();
        $res = DB::table('users')->where('id',$user_id)->update( ['name'=>$name['name'] ]);
        if($res){
            return '200';
        }else{
            return '404';
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @method get
     * 账户管理页面
     */
    public function usermanger()
    {
        $user_id = Auth::id();
        $user = DB::table('users')
            ->join('user_info','users.id','=','user_info.user_id')
            ->where('users.id',$user_id)
            ->select('user_info.virtualcurrency','user_info.dls_apply','users.*')
            ->first();

        return view('home.member.usermanger',['data'=> $user]);

    }

    /**
     * 修改支付密码
     * @param Request $request
     * @return string
     *
     */
    public function payPassUpdate(Request $request)
    {
        //获取用户id
        $userId = Auth::id();
        //接受数据
        $data = $request -> except('_token','s');
//        $this->validate($request, [
//            'password' => 'required|string|min:6|confirmed',
//        ]);

        //查询数据
        $res = DB::table('users') -> where('id',$userId) -> first();
		if($data['password'] != $data['password_confirmation']){
			return "407";
		}

        //判断原密码是否正确
        if(!Hash::check($data['oldpwd'],$res->pay_pass)){
            return "405";
        }

        //密码加密
        $pay_pass = Hash::make($data['password']);
        //修改状态
        $res2 = DB::table('users') -> where('id',$userId) -> update(['pay_pass' => $pay_pass]);
        if($res2)
        {
            return '200';
        }else
        {
            return "404";
        }
    }

    /**
     * @param Request $request
     * 设置支付密码
     */
    public function setPayPass(Request $request)
    {
        $user_id = Auth::id();
        $data = $request->except('_token','s');
        $res = DB::table('users')->where('id',$user_id)->select('pay_pass')->first();

        if($res->pay_pass != null){
            return "已设置";
        }
        if($data['password'] != $data['password_confirmation']){
            return "404";
        }
        $pay_pass = Hash::make($data['password']);
        $res1 = DB::table('users')->where('id',$user_id)->update(['pay_pass'=>$pay_pass]);
        if($res1){
            return "200";
        }else{
            return "404";
        }
    }

}
