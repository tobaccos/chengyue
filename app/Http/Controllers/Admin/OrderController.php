<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use Session;

class OrderController extends CommonController
{
  
     //订单列表页
    public function orderList(Request $request)
    {
        //判断是否有起止时间
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
//        var_dump($start);
        $keyword = $request -> input('keyword','');
        $status = $request -> input('status','');
        if($status == null)
        {
            $row = [];
        }else{
            $row = [];
            $row['orders.order_status'] = $status;
        }
        $res = DB::table('orders')
            -> join('users','orders.user_id','=','users.id')
            -> select('order_sn','table_type','demand1','demand2')
            -> whereRaw('instr(order_sn, \''. $keyword .'\') > 0')
            -> whereRaw('instr(name, \''. $keyword .'\') > 0')
            -> whereBetween('addtime',[$start,$end])
            -> where($row)
            -> orderBy('addtime','desc')
            -> paginate(10);

        // dd($status,$res);
        $data= array();
        foreach ($res as $re) {
            $row['order_sn'] = $re -> order_sn;
            if($re -> table_type == 0)
            {
                $data[] = DB::table('orders')
                -> join('users','users.id','=','orders.user_id')
                -> select('orders.table_type','users.name','orders.order_amount','orders.id','orders.order_sn','orders.pro_attr','orders.pay_amount','orders.order_status','orders.addtime','orders.filename','orders.pro_id as pname','demand1','demand2')
                -> where('orders.order_fsn','=',0)
                -> where($row)
                -> first();
                continue;
            }elseif($re -> table_type == 1)
            {
                $table = 'product';
            }elseif($re -> table_type == 2)
            {
                $table = 'recommend';
            }elseif($re -> table_type == 3)
            {
                $table = 'pre_buy';
            }elseif($re -> table_type == 4)
            {
                $table = 'activity';
            }

            $data[] = DB::table('orders')
                -> join('users','users.id','=','orders.user_id')
                -> join($table,"$table.id",'=','orders.pro_id')
                -> select('orders.table_type','users.name','orders.order_amount','orders.id','orders.order_sn',"$table.name as pname",'orders.pro_attr','orders.pay_amount','orders.order_status','orders.addtime','orders.filename','demand1','demand2')
                -> where('orders.order_fsn','=',0)
                -> where($row)
                -> first();
        }
        // dd($data);
        //处理时间
        foreach($data as $k => $v)
        {
            // dd($v);
            if( !$v ){
                unset( $data[$k] );
            }else{
                if($v -> pname == '0')
                {
                    $v -> pname = "请查看详情";
                }
                //处理json
                $pro_attr = json_decode($v->pro_attr);
                $v->addtime = date('Y-m-d H:i:s', $v->addtime);
                if($pro_attr == null)
                {
                    $v -> num = 0;
                    continue;
                }
                $v -> num = $pro_attr->num;
                
            }
        }
        // dd($data);
        return view('admin/order/orderList',['data' => $data,'res'=>$res,'request' => $request -> all()]); //全部订单
}
    //c除全部订单外的订单列表/已发货
    public function orderIndex(Request $request,$num)
    {
        //判断是否有起止时间
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
//        var_dump($start);
        $keyword = $request -> input('keyword','');
         $res = DB::table('orders')
            ->select('order_sn','table_type')
            ->where('order_status',$num)
            -> where('order_fsn','=','0')
            ->whereRaw('instr(order_sn, \''. $keyword .'\') > 0')
            ->orderBy('addtime','desc')
            ->paginate(10);

         $data= array();
        foreach ($res as $re) {
            if($re -> table_type == 0)
            {
               $data[] = DB::table('orders')
                    -> join('users','users.id','=','orders.user_id')
                    -> join('orderinfo','orders.order_sn','=','orderinfo.order_sn')
                    -> select('orders.table_type','users.name','orders.order_amount','orders.id','orders.order_sn','orders.pro_attr','orders.pay_amount','orders.order_status','orders.addtime','orders.filename','orderinfo.shipping_time','orders.demand1','orders.demand2','orders.pro_id as pname')
                    -> where('orders.order_sn',$re -> order_sn)
                    -> whereBetween('orderinfo.shipping_time',[$start,$end])
                    ->first();

                continue;
            }elseif($re -> table_type == 1)
            {
                $table = 'product';
            }elseif($re -> table_type == 2)
            {
                $table = 'recommend';
            }elseif($re -> table_type == 3)
            {
                $table = 'pre_buy';
            }elseif($re -> table_type == 4)
            {
                $table = 'activity';
            }

            $data[] = DB::table('orders')
                    -> join('users','users.id','=','orders.user_id')
                    -> join('orderinfo','orders.order_sn','=','orderinfo.order_sn')
                    -> join($table,"$table.id",'=','orders.pro_id')
                    -> select('orders.table_type','users.name','orders.order_amount','orders.id','orders.order_sn',"$table.name as pname",'orders.pro_attr','orders.pay_amount','orders.order_status','orders.addtime','orders.filename','orderinfo.shipping_time','orders.demand1','orders.demand2')
                    -> where('orders.order_sn',$re -> order_sn)
                    -> where('orders.order_fsn','=',0)
                    -> whereBetween('orderinfo.shipping_time',[$start,$end])
                    ->first();
                    // dd($data);
        }
        // dd($data);
        //处理时间
        foreach($data as $k => $v)
        {
            // dd($v);
            if( !$v ){
                unset( $data[$k] );
            }else{
                if($v -> pname == '0')
                {
                    $v -> pname = "请查看详情";
                }
                //处理json
                $pro_attr = json_decode($v->pro_attr);
                $v->addtime = date('Y-m-d H:i:s', $v->addtime);
                $v->shipping_time = date('Y-m-d H:i:s', $v->shipping_time);
                if($pro_attr == null)
                {
                    $v -> num = 0;
                    continue;
                }
                $v -> num = $pro_attr->num;
                
            }
        
        }
       // var_dump($data);die;
        switch($num)
        {
            case 1:
                return view('admin/order/orderMade',['data' => $data,'res'=>$res,'request' => $request -> all()]); //待制作
                break;
            case 2:
                return view('admin/order/orderDeliver',['data' => $data,'res'=>$res,'request' => $request -> all()]); //待发货
                break;
            case 3:
                return view('admin/order/orderDelivering',['data' => $data,'res'=>$res,'request' => $request -> all()]); //已发货
                break;
        }
    }

   //订单详情页
    public function detail($orderId)
    {
        $res = DB::table('orders') -> select('order_sn','table_type')-> where('id',$orderId) -> first();
        $dingdan = DB::table('orders')
                -> join('orderinfo as ori','orders.order_sn','=','ori.order_sn')
                -> join('users','orders.user_id','=','users.id')
                -> select('users.name','orders.pay_name','orders.addtime','orders.pay_amount','orders.order_status','orders.order_amount','ori.shipping_name','ori.shipping_code','orders.user_note','orders.order_sn')
                -> where('orders.id',$orderId)
                -> first();
         $dingdan -> addtime = date('Y-m-d H:i:s',$dingdan -> addtime);        
         $dingdan -> id = $orderId;
        //查询订单详情
        if($res -> table_type == 0)
        {
            $row = DB::table('orders') -> select('order_sn','table_type') -> where('order_fsn',$res -> order_sn) -> get();
        }else{
            $row =  DB::table('orders') -> select('order_sn','table_type') -> where('order_sn',$res -> order_sn) -> get();
        }
// dd($row);
        $data = array();
        foreach ($row as $v) {
        // dd($v);
           if($v -> table_type == 1)
            {
                $table = 'product';
                $com_atty = 'product.con_attr';
            }elseif($v -> table_type == 2)
            {
                $table = 'recommend';
                $com_atty = 'recommend.com_attr';
            }elseif($v -> table_type == 3)
            {
                $table = 'pre_buy';
                $com_atty = 'pre_buy.com_attr';
            }elseif($v -> table_type == 4)
            {
                $table = 'activity';
                $com_atty = 'activity.com_attr';
            }
            //查询用户的送货地址
            $addressId = DB::table('orderinfo') -> where('order_sn',$v -> order_sn) -> value('address');
            $date = DB::table('user_address') -> where('id',$addressId) -> first();

            $data[] = DB::table('orders')
                -> join('orderinfo as ori','orders.order_sn','=','ori.order_sn')
                -> join('users','orders.user_id','=','users.id')
                -> join($table,'orders.pro_id','=',"$table.id")
                -> select('users.name','orders.pro_attr','orders.pay_name','orders.addtime',"$table.id","$com_atty as com_attr","$table.name as pname",'orders.pay_amount','orders.dis_count','orders.order_status','orders.logis','orders.order_amount','ori.shipping_name','ori.shipping_code','orders.user_note','orders.order_sn')
                -> where('orders.order_sn',$v -> order_sn)
                -> first();
             }  
             foreach($data as $k => $v)
             {
                if(!$v){
                    unset( $data[$k] );
                    continue;
                }
                // dd($v);
                // 处理时间
                $v -> addtime = date('Y-m-d H:i:s',$v -> addtime);
                
                //处理json
                $pro_attr = json_decode($v -> pro_attr);
                $v -> num = $pro_attr -> num;
                
                //单位
                $com_attr = json_decode($v -> com_attr);
                $v -> unit= $com_attr['0'] -> unit;
                $v -> time = date('Y-m-d',time());
             } 

            //收货地址
            $date -> address = $date -> address1.$date -> address2.$date -> address3.$date -> address4.$date -> address5.$date -> address_details;
                //收货电话
            $date -> phone = $date -> phone;
                
           
        return view('admin.order.orderDetail',['data' => $data,'date' => $date,'dingdan'=>$dingdan]);
    }




    //删除
    public function delete()
    {
        $id = $_GET;
        //查询是否被用户删除
        $res = DB::table('orders')
                -> select('orders.is_delete','orders.order_sn')
                -> where('orders.id',$id)
                -> first();
        //判断
//        echo 'aaa';die;
        if($res -> is_delete == 1)
        {
            //执行删除
            DB::beginTransaction();
            try{
                $res1 = DB::table('orders') -> delete($id);
                $res2 = DB::table('orderinfo') -> where('order_sn',$res -> order_sn)-> delete();
                DB::commit();
                echo '删除成功';
            }catch (\Exception $e) {
                DB::rollBack();
                echo '删除失败';
            }
        } else
        {
            echo '用户删除前不可删除';
        }
    }

    //出库页面
    public function logistic($orderId)
    {
       $res = DB::table('orders') -> select('order_sn','table_type')-> where('id',$orderId) -> first();
        $dingdan = DB::table('orders')
                -> join('orderinfo as ori','orders.order_sn','=','ori.order_sn')
                -> join('users','orders.user_id','=','users.id')
                -> select('users.name','orders.pay_name','orders.addtime','orders.pay_amount','orders.order_status','orders.order_amount','ori.shipping_name','ori.shipping_code','orders.user_note','orders.order_sn')
                -> where('orders.id',$orderId)
                -> first();
         $dingdan -> addtime = date('Y-m-d H:i:s',$dingdan -> addtime);        
         $dingdan -> id = $orderId;
        //查询订单详情
        if($res -> table_type == 0)
        {
            $row = DB::table('orders') -> select('order_sn','table_type') -> where('order_fsn',$res -> order_sn) -> get();
        }else{
            $row =  DB::table('orders') -> select('order_sn','table_type') -> where('order_sn',$res -> order_sn) -> get();
        }
// dd($row);
        $data = array();
        foreach ($row as $v) {
        // dd($v);
           if($v -> table_type == 1)
            {
                $table = 'product';
                $com_atty = 'product.con_attr';
            }elseif($v -> table_type == 2)
            {
                $table = 'recommend';
                $com_atty = 'recommend.com_attr';
            }elseif($v -> table_type == 3)
            {
                $table = 'pre_buy';
                $com_atty = 'pre_buy.com_attr';
            }elseif($v -> table_type == 4)
            {
                $table = 'activity';
                $com_atty = 'activity.com_attr';
            }
            //查询用户的送货地址
            $addressId = DB::table('orderinfo') -> where('order_sn',$v -> order_sn) -> value('address');
            $date = DB::table('user_address') -> where('id',$addressId) -> first();

            $data[] = DB::table('orders')
                -> join('orderinfo as ori','orders.order_sn','=','ori.order_sn')
                -> join('users','orders.user_id','=','users.id')
                -> join($table,'orders.pro_id','=',"$table.id")
                -> select('users.name','orders.pro_attr','orders.pay_name','orders.addtime',"$table.id","$com_atty as com_attr","$table.name as pname",'orders.pay_amount','orders.dis_count','orders.order_status','orders.logis','orders.order_amount','ori.shipping_name','ori.shipping_code','orders.user_note','orders.order_sn')
                -> where('orders.order_sn',$v -> order_sn)
                -> first();
             }  
             foreach($data as $k => $v)
             {
                if(!$v){
                    unset( $data[$k] );
                    continue;
                }
                // dd($v);
                // 处理时间
                $v -> addtime = date('Y-m-d H:i:s',$v -> addtime);
                
                //处理json
                $pro_attr = json_decode($v -> pro_attr);
                $v -> num = $pro_attr -> num;
                
                //单位
                $com_attr = json_decode($v -> com_attr);
                $v -> unit= $com_attr['0'] -> unit;
                $v -> time = date('Y-m-d',time());
             } 

            //收货地址
            $date -> address = $date -> address1.$date -> address2.$date -> address3.$date -> address4.$date -> address5.$date -> address_details;
                //收货电话
            $date -> phone = $date -> phone;
        //判断该订单是否为制作完成订单
        if($dingdan -> order_status == 2)
        {
            return view('admin.order.logistic', ['data' => $data,'date' => $date,'dingdan'=>$dingdan]);
        }else
        {
            return back() -> with(['info' => '请仔细核对订单状态']);
        }
    }

    //出库
    public function lib()
    {
        //判断该订单是否为制作完成订单
        $res = DB::table('orders') -> where('id',$_GET['id']) -> first();
        if(empty($_GET['code']))
        {
            echo '物流单号不能为空，请点击下面的生成！';die;
        }
        if($res -> order_status == 2)
        {
            //修改物流名称和单号
            $shoopTime = time();
            $re = DB::table('orderinfo') -> where('order_sn',$res-> order_sn) -> update(['shipping_name' => $_GET['name'],'shipping_code' => $_GET['code'],'shipping_time' => $shoopTime]);
            // $rer = DB::table('orderinfo') -> where('order_fsn',$res-> order_sn) -> update(['shipping_name' => $_GET['name'],'shipping_code' => $_GET['code'],'shipping_time' => $shoopTime]);
            //更改数据库状态
            $r = DB::table('orders') -> where('id',$_GET['id']) -> update(['orders.order_status'=>3]);
            $rr = DB::table('orders') -> where('order_fsn',$res-> order_sn) -> update(['orders.order_status'=>3]);
            if($r|| $re)
            {
                 echo '出库成功';
            }else
            {
                echo '出库失败';
            }
        }else{
            echo '请仔细查看订单状态';
        }
    }

    //制作完成
    public function succ()
    {
        $id = $_GET['id'];
        //判断该订单是否为支付完成待制作
        $res = DB::table('orders') -> where('id',$id) -> first();
        if($res -> order_status == 1)
        {
            //更改数据库状态
            $r = DB::table('orders') -> where('id',$id) -> update(['orders.order_status'=>2]);
            if($r)
            {
                echo '状态更新成功';
            }else
            {
                echo '状态更新失败';
            }
        }else{
            echo '请仔细查看订单状态';
        }
    }

    //批量出库页面
    public function library()
    {
        return view('admin/order/library');
    }

    //修改价格
    public function updatePrice(Request $request)
    {
        //数据验证
        $this -> validate($request,[
            'dls_count' => 'min:0',
            'logis' => 'min:0',
        ],[
            'dls_count.min' => '不能低于0',
            'logis.min' => '不能低于0',
        ]);
        //处理数据
        $data = $request -> except('_token','s');
        if($data['dis_count']==null)
        {
            $data['dis_count'] = 0;
        }
//        var_dump($data);
        //查出订单应付数据
        $order= DB::table('orders') -> select('order_amount')-> where('id',$data['id']) -> get();
//        var_dump($order[0]->order_amount);die;
        //计算实付金额
        $pay_amount = $order[0]->order_amount - $data['dis_count'] + $data['logis'];
//        var_dump($pay_amount);die;
        //更新数据库
        $res = DB::table('orders') -> where('id',$data['id']) -> update(['dis_count' => $data['dis_count'],'logis' => $data['logis'],'pay_amount' => $pay_amount]);
        if($res)
        {
            return back() -> with(['info' => '成功']);
        }else{
            return back() -> with(['info' => '请重试']);
        }
//        var_dump($order_amount);
    }

    //执行批量出库
    public function batchLibrary(Request $request)
    {
        //数据验证
        $req = $request -> except('_token','s');
        // foreach ($req as $v) {
        //     if(empty($v))
        //     {
        //         return back() -> with(['info' => '请仔细检查出库信息']);
        //     }
        // }
        //判断是否有起止时间
        if($req['start'])
        {
            $req['start'] = strtotime($req['start']);
        }else
        {
            $req['start'] = 0;
        }
        if($req['start'])
        {
            $req['end'] = strtotime($req['end']);
        }else
        {
            $req['end'] = time();
        }

        $where['address1'] = $req['address1'];
        $where['address2'] = $req['address2'];
        if($req['address3'] != null)
        {
            $where['address3'] = $req['address3'];
        }
//        var_dump($req);die;
        //先匹配收货地址`
        $data = DB::table('user_address')
            -> where($where)
            -> select('id')
            -> get()
            -> toArray();
       // var_dump($data);die;
//        var_dump(DB::getQueryLog());die;
        if(empty($data))
        {
            return back() -> with(['info' => '该地区没有要出库商品']);
        }else{
            //获取所有地址id
            foreach ($data as $item) {
                $id[] = $item-> id;
            }
            //查询该地区为出库的订单
            $res = DB::table('orderinfo')
                -> join('user_address','user_address.id','=','orderinfo.address')
                -> join('orders','orders.order_sn','=','orderinfo.order_sn')
                -> select('orders.id','orders.order_sn')
                -> whereIn('orderinfo.address',$id)
                -> where('orders.order_status',2)
                ->whereBetween('orders.addtime', [$req['start'], $req['end']])
                -> get()
                -> toArray();
            // var_dump($res);die;
            if(empty($res))
            {
                return back() -> with(['info' => '该地区没有要出库商品']);
            }else
            {
                //执行批量出库
                foreach ($res as $v) {
                    //修改订单状态
                    $piliang = DB::table('orders') -> where('id',$v -> id) -> update(['order_status'=>3]);
                    //修改物流信息
                    $shipping_time = time();
                    $pl = DB::table('orderinfo') -> where('order_sn',$v -> order_sn) -> update(['shipping_name' => $req['shipping_name'],'shipping_code' => $req['shipping_code'],'shipping_time' => $shipping_time]);
                }
                // dd($piliang);
                if($piliang)
                {
                    return redirect('admin/order/orderDelivering/3') -> with(['info' => '批量出库成功']);
                }else
                {
                    return back() -> with(['info' => '请重试']);
                }
            }
        }
    }

    //文件下载
    public function download($id)
    {
        //查询数据
        $res = DB::table('orders')-> select('user_id','filename') -> where('id',$id) -> first();
        if($res->filename){
//            var_dump($res);die;
            return response()->download(
                realpath(base_path('public/uploads/user_file')).'/'.$res -> user_id.'/'.$res -> filename
            );
        }else{
            return back() -> with(['info' => '用户没有上传文件']);
        }
//
    }

    //销量图
    public function char()
    {
        //查询产品
        $data = DB::table('pro_type') -> select('id','name') -> get();
        return view('admin.order.chart',['data' => $data]);
    }

    //查询销量图数据
    public function num()
    {
        $id= $_GET['id'];
        $time= $_GET['time'];
        $class= $_GET['class'];

        if($class == 1)
        {
            $table = 'product';
        }elseif($class == 2)
        {
            $table = 'recommend';
        }elseif($class == 3)
        {
            $table = 'pre_buy';
        }elseif($class == 4)
        {
            $table = 'activity';
        }
        $where = [];
        if($id == 0)
        {
           $where['orders.table_type'] = $class;
        }else{
            $where['pro_type.id'] = $id;
            $where['orders.table_type'] = $class;
        }
        //获取现在的时间
        $now = time();
        //准备数据数组.目的是存放返回数据
        $number = array();
        //查询出产品的销售量
        if($time==7 || $time==30)
        {
            for($i=1;$i<=$time;$i++ )
            {
                $endtime = $now - 60*60*24*$i;
                //查询数据
                $data = DB::table($table)
                    -> join('orders','pro_id','=',$table.".id")
                    -> join('pro_type',$table.'.type_id','=',"pro_type.id")
                    -> select('orders.pro_attr')
                    ->where('orders.order_status','>',0)
                    ->where($where)
                    ->whereBetween('orders.addtime', [$endtime, $now])
                    ->get();
                //处理查询出来的数据.目的:获取数量
                $num = 0;
                foreach ($data as $item) {
                    //处理数组
                    $attr = json_decode($item->pro_attr,true);
                    $num +=$attr['num']+0;
                    $now = $endtime;
                }
                $number[] = $num;
            }

        }else if($time==6 || $time==12){
            for($i=1;$i<=$time;$i++ )
            {
                $endtime = $now - 60*60*24*30*$i;
                //查询数据
                $data = DB::table($table)
                    -> join('orders','pro_id','=',$table.".id")
                    -> join('pro_type',$table.'.type_id','=',"pro_type.id")
                    -> select('orders.pro_attr')
                    ->where('orders.order_status','>',0)
                    ->where($where)
                    ->whereBetween('orders.addtime', [$endtime, $now])
                    ->get();
                //处理查询出来的数据.目的:获取数量
                $num = 0;
                foreach ($data as $item) {
                    //处理数组
                    $attr = json_decode($item->pro_attr,true);
                    $num +=$attr['num']+0;
                    $now = $endtime;
                }
                $number[] = $num;
            }
        }
        return array_values($number);
    }

    //批量删除
    public function dels()
    {
        $ids = $_GET['ids'];
        //遍历数据
        foreach ($ids as $id) {
            //查询是否被用户删除
            $res = DB::table('orders')
                -> select('orders.is_delete','orders.order_sn')
                -> where('orders.id',$id)
                -> first();
            if($res == null)
            {
                continue;
            }
            //判断
            if($res -> is_delete == 1)
            {
                //执行删除
                DB::beginTransaction();
                try{
                    $res1 = DB::table('orders') -> delete($id);
                    $res2 = DB::table('orderinfo') -> where('order_sn',$res -> order_sn)-> delete();
                    DB::commit();
                }catch (\Exception $e) {
                    DB::rollBack();
                    echo '删除失败';die;
                }
            } else
            {
                echo '用户删除前不可删除';die;
            }
            echo '删除成功';
        }
    }

    //查看文件
    public function upload($id)
    {
        $res = DB::table('orders') -> where('id',$id) -> first();
        $data[] = explode('&&', $res -> demand1);
        $data[] = explode('&&', $res -> demand2);
        return view('admin/order/orderUpload',['data' => $data]);
    }
}
