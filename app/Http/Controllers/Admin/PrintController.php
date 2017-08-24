<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class PrintController extends Controller
{
    //批量打印页面
    public function details(Request $request)
    {
        //获取id数组
        $datas = $request -> except('_token','s');
        $datas = $datas['ids'];
        $id = explode(',',$datas);
        
        foreach ($id as $key => $value) {
            if(empty($value) || $value == 'on')
            {
                unset($id[$key]);
            }
        }
        if(empty($id))
        {
             return back() -> with(['info' => '请选择订单']);
        }
        $date = array();
        $data = array();
        //遍历id
        foreach ($id as $orderId) {
            
            //取出所有订单的详细信息
            $res = DB::table('orders') -> select('order_sn','table_type') -> where('id',$orderId)-> first();
            //查询地址
            // $addressId = DB::table('orderinfo') -> where('order_sn',$res -> order_sn) -> value('address');
            // $date[] = DB::table('user_address') -> where('id',$addressId) -> first();
            //查询地址
            $date[] = DB::table('orderinfo')
             -> join('orders','orderinfo.order_sn','=','orders.order_sn')
             -> join('user_address','orderinfo.address','=','user_address.id')
             -> select('orderinfo.shipping_name','orderinfo.shipping_code','user_address.*','orders.pay_amount','orders.addtime','orders.pay_name')
             -> where('orders.order_sn',$res -> order_sn)
             -> first();
            //查询订单详情
            if($res -> table_type == 0){
                //查询父子订单
                $data[] = DB::table('orders')
                -> join('orderinfo as ori','orders.order_sn','=','ori.order_sn')
                -> join('users','orders.user_id','=','users.id')
                -> select('users.name','orders.pro_attr','orders.pay_name','orders.addtime','orders.pay_amount','orders.dis_count','orders.order_status','orders.logis','orders.order_amount','ori.shipping_name','ori.shipping_code','orders.user_note','orders.order_sn')
                -> where('orders.id',$orderId)
                -> first();
                continue;
            }elseif($res -> table_type == 1)
            {
                $table = 'product';
                $com_atty = 'product.con_attr';
            }elseif($res -> table_type == 2)
            {
                $table = 'recommend';
                $com_atty = 'recommend.com_attr';
            }elseif($res -> table_type == 3)
            {
                $table = 'pre_buy';
                $com_atty = 'pre_buy.com_attr';
            }elseif($res -> table_type == 4)
            {
                $table = 'activity';
                $com_atty = 'activity.com_attr';
            }

            $data[] = DB::table('orders')
                -> join('orderinfo as ori','orders.order_sn','=','ori.order_sn')
                -> join('users','orders.user_id','=','users.id')
                -> join($table,'orders.pro_id','=',"$table.id")
                -> select('users.name','orders.pro_attr','orders.pay_name','orders.addtime',"$table.id","$com_atty as com_attr","$table.name as pname",'orders.pay_amount','orders.dis_count','orders.order_status','orders.logis','orders.order_amount','ori.shipping_name','ori.shipping_code','orders.user_note')
                -> where('orders.id',$orderId)
                -> first();

        }

        foreach ($data as $k => $v) {
            if(!isset($v -> order_sn))
            {
                continue;
            }
            $data[$k] = DB::table('orders') -> where('order_fsn',$v -> order_sn) ->get();
            foreach ($data[$k] as  $key => $val) {


                if($val -> table_type == 1)
                {
                    $table = 'product';
                    $com_atty = 'product.con_attr';
                }elseif($val -> table_type == 2)
                {
                    $table = 'recommend';
                    $com_atty = 'recommend.com_attr';
                }elseif($val -> table_type == 3)
                {
                    $table = 'pre_buy';
                    $com_atty = 'pre_buy.com_attr';
                }elseif($val -> table_type == 4)
                {
                    $table = 'activity';
                    $com_atty = 'activity.com_attr';
                }

                $data[$k][$key] = DB::table('orders')
                    -> join('orderinfo as ori','orders.order_sn','=','ori.order_sn')
                    -> join('users','orders.user_id','=','users.id')
                    -> join($table,'orders.pro_id','=',"$table.id")
                    -> select('users.name','orders.pro_attr','orders.pay_name','orders.addtime',"$table.id","$com_atty as com_attr","$table.name as pname",'orders.pay_amount','orders.dis_count','orders.order_status','orders.logis','orders.order_amount','ori.shipping_name','ori.shipping_code','orders.user_note')
                    -> where('orders.id',$val -> id)
                    -> first();
            }
        }
        foreach ($data as $k => $v) {
            if(isset($v -> name))
            {
                // 处理时间
                $v -> addtime = date('Y-m-d H:i:s',$v -> addtime);
                $v -> id = $orderId;
                //处理json
                $pro_attr = json_decode($v -> pro_attr);
                //数量
                $v -> num = $pro_attr -> num;
                //单位
                $com_attr = json_decode($v -> com_attr);
                $v -> unit= $com_attr['0'] -> unit;
            }else{
                foreach ($v as $key => $value) {
                    $value -> addtime = date('Y-m-d H:i:s',$value -> addtime);
                    $value -> id = $orderId;
                    //处理json
                    $pro_attr = json_decode($value -> pro_attr);
                    //数量
                    $value -> num = $pro_attr -> num;
                    //单位
                    $com_attr = json_decode($value -> com_attr);
                    $value -> unit= $com_attr['0'] -> unit;
                }
            }
        }
        //收货地址
        foreach ($date as $k =>  $v) {
            if(empty($v))
            {
                return back() -> with(['info' => '已选中订单有信息错误']);
            }
            $v -> address = $v -> address1.$v -> address2.$v -> address3.$v -> address4.$v -> address5.$v -> address_details;
            $v -> addtime = date('Y-m-d H:i:s',$v -> addtime);
        }
        //将父订单取出
        $data1 = array();
        foreach ($data as $key => $value) {
            if(!isset($value -> name))
            {
                foreach ($value as $k => $v) {
                    $data1[$key][] = $v;
                }
            }
        }   
        //按需求取出数组
        foreach ($data1 as $key => $value) {
            $data2[$key][0] = array_slice($value, 0, 4);
            for ($i=1; $i <= ceil((count($value)-4)/5); $i++) {
                $data2[$key][$i] = array_slice($value, ($i*5)-1,5);
            }
        }
        // dd($data2);
        if(isset($data2))
        {
            return view('admin.order.orderDetails',['data' => $data,'date' => $date,'data2' => $data2]);
        }else{
            return view('admin.order.orderDetails',['data' => $data,'date' => $date]);
        }
    }
}
