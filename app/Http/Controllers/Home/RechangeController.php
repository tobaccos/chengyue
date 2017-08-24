<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\AlipayController;
use App\Http\Models\OrderInfo;
use App\Http\Models\Orders;
use App\Http\Models\Rechange;
use App\Http\Models\User;
use App\Http\Models\UserInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;

class RechangeController extends CommonController
{
    //我的钱包
    public function price()
    {
        $userId = Auth::id();//用户id
        $userInfo = UserInfo::where('user_id',$userId)->first()->toArray();
        return view('home.member.price',compact('userInfo'));//钱包
    }
    //余额充值
    public function recharge(Request $request)
    {
        //判断用户是否登录
        $userId = Auth::id();//用户id
        if(!empty($request->price))
            $priceArr = explode(',',$request->price);

        if($request->isMethod('post') && !empty($priceArr[0])){
            //生产充值订单
            $price = $priceArr[0];
            $recharge_sn = getOrderId($userId);
            Rechange::create(['user_id'=>$userId, 'money'=>$price, 'pay_type'=>$priceArr[1], 'state'=>0, 'created_at'=>time(), 'recharge_sn'=>$recharge_sn]);
            //创建支付链接
            if($priceArr[1] == 0){
                $alipay = new AlipayController();
                $alipay->pay('MR'.$recharge_sn, $price);
            }elseif($priceArr[1] == 1){
                //微信支付
            }
        }
        $userInfo = UserInfo::where('user_id',$userId)->first()->toArray();
        return view('home.member.withdrawals', compact('userInfo'));//充值
    }
    //余额查询
    //余额支付
    public function pay($order, Request $request)
    {
        $userId = Auth::id();//用户id
        //验证支付密码
        $user = User::where('id',$userId)->first()->toArray();
        if(empty($user['pay_pass']))
            return redirect('home/member/setzhi');//设置支付密码
        //判断余额是否充足
        $userInfo = UserInfo::where('user_id',$userId)->first()->toArray();
        //多订单总价
        $order_amount = 0;
		//
		$error = '';
        if(strpos($order, '_') !== false){
            $orderArr = explode('_', $order);
            foreach($orderArr as $v){
                $oInfo = Orders::select('pay_amount')->where('order_sn', $v)->get()->first()->toArray();
                $order_amount += $oInfo['pay_amount'];
            }
        }else{
            $orderInfo = Orders::where('order_sn',$order)->first()->toArray();
            $order_amount = $orderInfo['order_amount'];
        }
        if($userInfo['virtualcurrency'] < $order_amount)
            return redirect('home/shopping/less'.'?state=1');//'余额不足';		
        elseif(!empty(trim($request->pwd,',')) && !Hash::check(trim($request->pwd,','),$user['pay_pass']))//判断支付密码是否正确
            $error = '支付密码错误';//return redirect('home/shopping/less'.'?state=2');//'支付密码错误';
        elseif($request->isMethod('post') && !empty(trim($request->pwd,','))){

            //事务
            DB::beginTransaction();
            try{
                //更改订单状态
                //多订单
                if(strpos($order, '_') !== false){
                    $orderArr = explode('_', $order);
                    foreach($orderArr as $v){
                        $oInfo = Orders::select('pay_amount')->where('order_sn', $v)->get()->first()->toArray();
                        $this->_setOrderInfo($v,$oInfo['pay_amount']);
                        //更改余额
                        UserInfo::where('user_id',$userId)->decrement('virtualcurrency',$oInfo['pay_amount']);
                    }
                }else{
                    $this->_setOrderInfo($order,$orderInfo['order_amount']);
                    //更改余额
                    UserInfo::where('user_id',$userId)->decrement('virtualcurrency',$orderInfo['order_amount']);
                }

                DB::commit();
                return view('home.shopping.paySuccess');
            } catch (\Exception $e){
                DB::rollback();//事务回滚
                //echo $e->getMessage();
                //echo $e->getCode();
                return view('home.shopping.payFail');
            }
        }
        $userInfo = UserInfo::where('user_id',$userId)->first()->toArray();
        return view('home.shopping.vpay', compact('userInfo','error'));
    }


    //更新订单信息
    private function _setOrderInfo($order_sn, $total_amount)
    {
        //
        $orderField = ['id','order_sn','order_fsn','pro_id','table_type','pro_attr','order_amount'];
        //
        Orders::where('order_sn', $order_sn)->update(['order_status'=>'1','pay_name'=>'1', 'pay_amount'=>$total_amount]);
        OrderInfo::where('order_sn', $order_sn)->update(['ad_update'=>$total_amount]);
        //更新销量
        $orderPro = Orders::select($orderField)->where('order_sn', $order_sn)->first()->toArray();
        if($orderPro['pro_id'] == 0){
            //查找子订单
            $orderPro = Orders::select($orderField)->where('order_fsn', $order_sn)->get()->toArray();
            foreach($orderPro as $v){
            	//更新父订单信息
                Orders::where([['order_fsn', $order_sn],['order_amount',$v['order_amount']]
                ])->update(['order_status'=>'1','pay_name'=>'1','pay_amount'=>$v['order_amount']]);
				//
				Orders::where('order_fsn', $v['order_sn'])->update(['order_status'=>'1','pay_name'=>'1', 'pay_amount'=>$v['order_amount']]);
				OrderInfo::where('order_fsn', $v['order_sn'])->update(['ad_update'=>$v['order_amount']]);
				//
                $op = Orders::select($orderField)->where('order_sn', $v['order_sn'])->first()->toArray();
                $this->_setVolume($op['table_type'],$op['pro_id'],$op['pro_attr']);
            }
        }else{
            $res = Orders::where('order_fsn',$order_sn)->first();
            Orders::where('order_fsn', $order_sn)->update(['order_status'=>'1','pay_name'=>'1','pay_amount'=>$res['order_amount']]);
            $this->_setVolume($orderPro['table_type'],$orderPro['pro_id'],$orderPro['pro_attr']);
        }
    }

    //更新销量
    private function _setVolume($table_type,$pro_id,$pro_attr)
    {
        $proAttr = json_decode($pro_attr,true);
        DB::table(get_pro_table($table_type))->where('id',$pro_id)->increment('volume',$proAttr['num']);
    }
}
