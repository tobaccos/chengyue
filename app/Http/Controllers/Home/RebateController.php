<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use DB;
use vendor\laravel\framework\src\Illuminate\Database\Query;

class RebateController extends Controller
{
    /*
     * 返利记录
     */

    public function rebate(Request $request)
    {
    	if($request -> isMethod('post')){
    		 //查询起始金额
        $ltime = strtotime($request->get('ltime'));
        $ftime = strtotime($request->get('ftime'));
		$ltime += 86390;
//        $ftime = 1; //
//        $ltime = 80;
        $userId = Auth::id();
        //返利总额
        $money = DB::table('rebate_log')
            ->select(DB::raw('sum(money) as money '))
            ->where([
                ['rebate_log.user_id',$userId],
                ['rebate_log.is_delete',0],
                ['rebate_log.state',3]
            ])
            ->first();

        //分页输出
        $data = DB::table('users')
                    ->join('rebate_log','users.id','=','rebate_log.user_id')
                    ->when($ftime,function ($query) use ($ftime,$ltime){
                        return $query->whereBetween('rebate_log.created_at',[$ftime,$ltime]);
                    })
                    ->where([
                        ['rebate_log.user_id',$userId],
                        ['rebate_log.is_delete',0],
                        ['rebate_log.state',3]
                    ])
                    ->get();

        $totalMoney = 0;
        foreach ($data as $value) {
          $totalMoney +=  $value->money;
        }
        $data->totalMoney = $totalMoney;

		      $str = '';
            foreach ($data as $value){
                $str .= '<tr>

									<input type="hidden" class="del" value=".$value->id." />

									<td class="td">'.$value->name.'</td>
									<td>'.date("Y-m-d" ,$value-> created_at).'</td>
									<td class="pos td">'.$value->money.'
										<img src="{{url("images/base/close.png")}}"/></td>
										</tr>';
            }

			return response() -> json($str);
    	}
        //查询起始金额
        $ltime = strtotime($request->get('ltime'));
        $ftime = strtotime($request->get('ftime'));

//        $ftime = 1; //
//        $ltime = 80;
        $userId = Auth::id();
        //返利总额
        $money = DB::table('rebate_log')
            ->select(DB::raw('sum(money) as money '))
            ->where([
                ['rebate_log.user_id',$userId],
                ['rebate_log.is_delete',0],
                ['rebate_log.state',3]
            ])
            ->first();

        //分页输出
        $data = DB::table('users')
                    ->join('rebate_log','users.id','=','rebate_log.user_id')
                    ->when($ftime,function ($query) use ($ftime,$ltime){
                        return $query->whereBetween('rebate_log.created_at',[$ftime,$ltime]);
                    })
                    ->where([
                        ['rebate_log.user_id',$userId],
                        ['rebate_log.is_delete',0],
                        ['rebate_log.state',3]
                    ])
                    ->get();

        $totalMoney = 0;
        foreach ($data as $value) {
          $totalMoney +=  $value->money;
        }
        $data->totalMoney = $totalMoney;



        return view('home.member.rebate',['data'=>$data,'totalMoney'=>$money]);
    }

    /*
     * 删除返利记录
     */
    public function rebateDel(Request $request)
    {

        $id = $request->only('id');
        $res = DB::table('rebate_log')->where(['id'=>$id])->update(['is_delete'=>1]);

        if(!$res){
            return '404';
        }
        return '200';
    }

    /*
     * 返利
     */
    public function toRebate()
    {
        // 返利时间
        $rebate_time = strtotime('-7 day');

        //所有的代理商
        $user = DB::table('user_info')
            ->where('dls_apply',2)
            ->get();
        foreach ($user as $key => $value)
        {
            //代理商id
            $father_id = $value->user_id;
            $data['user_id'] = $father_id;
            //用户余额
            $virtualcurrency = $value->virtualcurrency;
            //用户表返利总金额
            $rebate_amount = $value->rebate_amount;
            //所有线下会员
            $users = DB::table('users')
                ->where('father_id',$father_id)
                ->get();

            foreach ($users as $k => $v)
            {
                //用户id
                $user_id = $v->id;
                //获取用户的所有订单
                $order = DB::table('orders')
                    ->where([
                        ['user_id',$user_id],
                        ['state',0]
                    ])
                    ->whereIn('order_status',[4,5])
                    ->get();
                dd($order);
                if(!$order)
                {
                  echo '更新成功，无返利订单';
                  die;
                }
                //遍历订单
                foreach ($order as $i => $val)
                {
                    if($val->pro_attr){
                        //查询利率
                        $rate = getProPrice(json_decode($val->pro_attr))['rate'];

                        //下单时间
                        $add_time = $val->addtime;
                        //实付价格
                        $pay_amount = $val->pay_amount;
                        //订单号
                        $data['order_sn'] = $val->order_sn;
                        //购买人id
                        $data['buy_user_id'] = $val->user_id;
                        //订单产品总额
                        $data['pro_price'] = $val->pro_price;
                        //判断时间是否符合条件
                        if($add_time <= $rebate_time)
                        {
                            //商品属性有利率
                            if(!empty($rate) && $rate > 0)
                            {
                                $rebate = $pay_amount * $rate;
                            }else{
                                //查询商品的利率
                                //商品id
                                $pro_id = $val->pro_id;
                                //查询商品利率
                                $rate = DB::table('product')
                                    ->where('id',$pro_id)
                                    ->select('rate')
                                    ->first();
                                if(!empty($rate) && $rate->rate >0)
                                {
                                    //使用商品利率
                                    $rebate = $pay_amount * $rate->rate;
                                }else{
                                    //商品没有利率，使用基准利率
                                    $rebate = $pay_amount * RATE;
                                }
                            }

                            //用户表返利总金额
                            $rebate_amount += $rebate;
                            //用户余额加上返利金额
                            $virtualcurrency += $rebate;
                            //返利表返利
                            $data['money'] = $rebate;
                            //返利记录生成时间
                            $data['created_at'] = time();
                            //用户是否删除
                            $data['is_delete'] = 0;
                            //返利状态
                            $data['state'] = 3;
                            //用户表返利总金额
                            $user_info['rebate_amount'] = $rebate_amount;
                            //用户余额加上返利金额
                            $user_info['virtualcurrency'] = $virtualcurrency;
                            //订单状态 1已返利
                            $state['state'] = 1;

                            //开启事务
                            DB::beginTransaction();
                            //将返利记录写入返利表
                            $res1 = DB::table('rebate_log')->insert($data);
                            //更新订单状态
                            $res3 = DB::table('orders')->where('order_sn',$data['order_sn'])->update($state);
                            $res2 = DB::table('user_info')->where('user_id',$father_id)->update($user_info);
                            if($res1 && $res2 && $res3)
                            {
                                //成功提交
                                DB::commit();
                                echo "更新成功";
                            }else{
                                //失败回滚
                                DB::rollBack();
                                echo "更新失败";
                            }
                        }
                    }


                }


            }

        }
    }

    //返利提现页面
    public function index()
    {
        //查询为提现金额
        $userId = Auth::id();
//        var_dump($userId);die;
        $res = DB::table('user_info') -> select('virtualcurrency') -> where('user_id',$userId) -> first();
//      var_dump($money);die;
        //计算
        $money = $res->virtualcurrency;
//        var_dump($money);die;
        return view('/home/member/cash',['money' => $money]);
    }

    /*
     * 返利提现
     */
    public function cash(Request $request)
    {
        $input = $request->except('_token','s');

        $userId = Auth::id();
        //查询用户余额
        $user = DB::table('user_info')
            -> where('user_id',$userId)
            -> select('virtualcurrency')
            -> first();
        $money = $user->virtualcurrency;
        if($money < 100){
            return "406";//余额低于最低提现额度
        }
        $data = array();
        if($input['cash'] == 0){
            return "金额不能为0";
        }
        if($input['cash']%100 != 0){
            return "提现只能是100的倍数";
        }
        if($input['cash'] <= $money){

            $data['created_at'] = time();
            $data['user_id'] = $userId;
            $data['money'] = $input['cash'];
            $data['bank_name'] = $input['bank_name'];
            $data['bank_num'] = $input['bank_num'];
            //减去提现金额
            $rebateMoney = $money - $input['cash'];
            //开启事务
            DB::beginTransaction();
            //将提现记录写入提现表
            $res = DB::table('user_account')->insert($data);
            //扣除用户余额
            $res1 = DB::table('user_info')->where('user_id',$userId)->update(['virtualcurrency'=>$rebateMoney]);

            if($res && $res1)
            {
                // 提交
                DB::commit();
                return "提现成功";
            }else{
                // 回滚
                DB::rollback();
                return '提现失败！';
            }
        }else{
            return '提现失败！';
        }


    }


}
