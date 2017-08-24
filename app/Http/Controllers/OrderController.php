<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\AlipayController;
use App\Http\Controllers\WechatPayController;
use App\Http\Models\OrderInfo;
use App\Http\Models\Orders;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redis;

class OrderController extends Controller
{
    /*
     * 订单页
     */
    public function order()
    {
        $uid = Auth::id();//用户id
        if(!Auth::check()){
            return redirect('/login');
        }
        //查看用户是否填写收货地址
        $address = DB :: table('user_address')
            ->where([
                ['user_id',$uid],
                ['is_default',1]
              ])
            ->get();

//        if(empty($address->first()))
//            return redirect('home/member/address');
        if(!empty($address->first())){
            //遍历拼接地址
            foreach($address as $key=>$value){
                // 省
                $provice = !empty($value->address1)? $value->address1: '';
                // 市 北京
                $city = !empty($value->address2)? $value->address2: '';
                // 县
                $county = !empty($value->address3)? $value->address3: '';
                // 乡镇
                $town = !empty($value->address4)? $value->address4: '';
                // 村
                $village = !empty($value->address5)? $value->address5: '';

            }
            $data['addressStr'] = $provice.$city.$county.$town.$village;
            $info = $address;
        }else{
            $info = "";
        }


        //商品信息
        if(!empty(session('buy'))){
            $allinfo = session('buy');
            $allinfo = $allinfo['allinfo'];
        }elseif(!empty(Redis::get('Cart1'))){
            $cart = Redis::get('Cart1');
            $cart = unserialize($cart);
            $allinfo = [];
            foreach($cart['cart'][$uid] as $v){
                $allinfo[] = $v['datas'];
            }
        }

        $allDatas = array();
        $allPrice = 0;
        $nums = 0;
        foreach($allinfo as $key=>$proinfo) {
            $proId = $proinfo['proId'];
            $wherePro['id'] = $proId;
            $dataPro = DB:: table(get_pro_table($proinfo['typeNumber']))->where($wherePro)->get();
            //获取产品分类名
            $typeName = RequestDB('pro_type', array('name'), array('id' => $dataPro[0]->type_id));
            $data['typeName'] = $typeName[0]->name;
            //处理基本属性
            if (isset($proinfo['attrNameVal'])) {
                foreach ($proinfo['attrNameVal'] as $key => $value) {
                    if (!empty($value)) {
                        $dd = RequestDB('pro_attr', array('name'), array('id' => $key));
                        $attrNameVal[$dd[0]->name] = $value;
                    }

                }

            }


            //处理多选属性
            $selfAttrObject = [];
            if (isset($proinfo['selfAttrObject'])) {
                foreach ($proinfo['selfAttrObject'] as $val) {
                    $kk = explode('_', $val);
                    $dd = RequestDB('pro_attr', array('name'), array('id' => $kk));

                    $selfAttrObject[$dd[0]->name][] = $kk[1];//$val;
                }
            }

            $data['dataPro'] = $dataPro;
            $data['attrNameVal'] = $attrNameVal;
            $data['selfAttrObject'] = $selfAttrObject;
            $data['price'] = $proinfo['price1'] * $proinfo['num'];//dd($data);
            $allPrice += $data['price'];
            $data['num'] = $proinfo['num'];
            $data['order_sn'] = getOrderId($uid);
            $nums += $data['num'];
//            $data['json'] = json_encode($proinfo);
            $allDatas['datas'][] = $data;
        }
        $allDatas['allPrice'] = $allPrice;
        $allDatas['json'] = json_encode($allinfo);
        $allDatas['num'] = $nums;
        $allDatas['order_fsn'] = getOrderId($uid);
        $allinfo[1] = $allinfo[0];

        return view('home/shopping/order',['data'=>$allDatas],['info'=>$info]);
    }

    /*
     * 购物车到订单数据处理
     * */
    public function cartToOrder()
    {
        $uid = Auth::id();
        $res = Input::all();
        $data = '['. $res['data'] .']';
        //session(['Cart'=>null]);
        if(!is_null($data) &&  count(json_decode($data, true))>0){
            $cart = Redis::get('Cart');
            $cart = unserialize($cart);
            $ret = [];
            foreach(json_decode($data, true) as $k => $v){//购物车提交的数据
                foreach($cart['cart'][$uid] as $n => $vv){//购物车所有

                    if($v['proId'] == $vv['datas']['proId'] && $v['typeNumber'] == $vv['datas']['typeNumber']){
                        if(isset($v['selfAttrObject']))
                        {
                            if($v['selfAttrObject'] == json_encode($vv['datas']['selfAttrObject']) && $v['attrNameVal'] == json_encode($vv['datas']['attrNameVal'])){
                                $vv['datas']['num'] = $v['mum'];
                                $ret['cart'][$uid][] = $vv;
                                unset($cart['cart'][$uid][$n]);
                            }
                        }elseif($v['attrNameVal'] == json_encode($vv['datas']['attrNameVal'])){
                            $vv['datas']['num'] = $v['mum'];
                            $ret['cart'][$uid][] = $vv;
                            unset($cart['cart'][$uid][$n]);
                        }


                    }
                }
            }
            //如果购物车中没有返回
            if(empty($ret)){
                return back();
            }
            $cart = serialize($cart);
            Redis::set('Cart',$cart);
            $ret = serialize($ret);
            Redis::set('Cart1',$ret);
            Session::forget('buy');
            return redirect(url('home/shopping/order'));
        }
        return back(Input::all());
    }

    /**
     * 个人中心待支付
     */
    public function memberToOrder()
    {
        $params = Input::except('_token');
        $params = explode(',', $params['orders']);
        $orders = '';
        foreach($params as $v){
            $orders .= $v . '_';
        }
        $orders = trim($orders, '_');
        return view('home/shopping/pay',['data'=>$orders]);
    }

    /*
     * 立即购买数据临时处理
     */
    public function buy(Request $request)
    {
        Session::forget('buy');
        $datas = $request -> except('_token');
        session(['buy' => $datas]);
        $res = empty(session('buy'));
        if(!$res){
            return response() -> json(1);
        }else{
            return response() -> json(0);
        }

    }


    /*
      * 订单列表
      */
    public function orderList()
    {
        //全部订单
        $userId = Auth::id();
        $order_status['order_status'] = [1,2,3,4];
        $orders = DB::table('orders')
            ->where([
                ['user_id',$userId],
//                ['is_delete',0],
            ])
            ->whereIn('order_status',[0,1,2,3,4])
            ->whereNotIn('table_type', [0])
            ->get();
        $table = "";
        $res = [];
        if(count($orders) < 0)
        {
            $res = "";
        }

        foreach ($orders as $k => $v) {
            if ($v->table_type == 1) {
                $table = 'product';
            } elseif ($v->table_type == 2){
                $table = 'recommend';
            }elseif($v->table_type == 3) {
                $table = 'pre_buy';
            }elseif($v->table_type == 4){
                $table = 'activity';
            }

            // 未付款
            $weifu = DB::table('orders')
                ->join($table,$table.'.id','=','orders.pro_id')
                ->where([
                    ['orders.order_status',0],
                    ['orders.user_id',$userId],
                    [$table.'.id',$v->pro_id]
                ])
                ->whereNotIn('orders.table_type', [0])
                ->first();

            if($weifu){
                $res['weifu'][] = $weifu;
                continue;
            }

            // 待发货
            $weifa = DB::table('orders')
                ->join($table,$table.'.id','=','orders.pro_id')
                ->whereIn('orders.order_status',[1,2])
                ->whereNotIn('orders.table_type', [0])
                ->where([
                    ['orders.user_id',$userId],
                    [$table.'.id',$v->pro_id]
                ])
                ->first();
            if($weifa){
                $res['weifa'][] = $weifa;
                continue;
            }

            // 已发货
            $fahuo = DB::table('orders')
                ->join($table,$table.'.id','=','orders.pro_id')
                ->where([
                    ['orders.order_status',3],
                    ['orders.user_id',$userId],
                    [$table.'.id',$v->pro_id]
                ])
                ->whereNotIn('orders.table_type',[0])
                ->first();
            if($fahuo){
                $res['fahuo'][] = $fahuo;
                continue;
            }
            // 已收货
            $shou = DB::table('orders')
                ->join($table,$table.'.id','=','orders.pro_id')
                ->where([
                    ['orders.order_status',4],
                    ['orders.user_id',$userId],
                    [$table.'.id',$v->pro_id]
                ])
                ->whereNotIn('orders.table_type',[0])
                ->first();
            if($shou){
                $res['shou'][] = $shou;
                continue;
            }

        }

//        dd($res);
        foreach ($orders as $k => $v) {
            $typeNumber = $v->table_type;
            switch ($typeNumber) {
                case  1:
                    $table = 'product';
                    break;
                case  2:
                    $table = 'recommend';
                    break;
                case  3:
                    $table = 'pre_buy';
                    break;
                case  4:
                    $table = 'activity';
                    break;
            }
            $typeName = DB::table($table)
                ->join('pro_type', $table . '.type_id', '=', 'pro_type.id')
                ->where([
                    [$table . '.id', $v->pro_id],
                ])
                ->select('pro_type.name as type_name', $table . '.*')
                ->first();

            $v->type_name = $typeName->type_name;
            $v->name = $typeName->name;
            $v->min = $typeName->min;
            $v->max = $typeName->max;
            $v->thumbing = $typeName->thumbing;
            $pro_attr = json_decode($v->pro_attr);
            $v->num = $pro_attr->num;



        }

        foreach ($res as $value)
        {

            foreach ($value as $j => $val)
            {
                if($val){
                    if ($val->table_type == 1) {
                        $table = 'product';
                    } elseif ($val->table_type == 2){
                        $table = 'recommend';
                    }elseif($val->table_type == 3) {
                        $table = 'pre_buy';
                    }elseif($val->table_type == 4){
                        $table = 'activity';
                    }
                    $type_name = DB::table('pro_type')
                        ->join($table,$table.'.type_id','=','pro_type.id')
                        ->where($table.'.id',$val->pro_id)
                        ->select('pro_type.name')
                        ->first();
                    $pro_attr = json_decode($val->pro_attr);
                    $val->num = $pro_attr->num;
                    $val -> type_name = $type_name -> name;

                }


            }
        }


        return view('home.member.orderList',['data'=>$orders,'res' => $res]);

    }

    /*
     * 确认收货
     */
    public function confirm(Request $request)
    {
        $user_id = Auth::id();
        $order_sn = $request->only('id');
        $res = DB::table('orders')
                    ->where([
                        ['user_id',$user_id],
                        ['order_sn',$order_sn]
                    ])
                    ->update(['order_status'=> 4]);
        return $res ? "200" : "404";
    }

    /*
     * 删除订单
     */
    public function order_del(Request $request)
    {
        $user_id = Auth::id();
        $order_sn = $request->get('order_sn');
        $res = DB::table('orders')
            ->where('order_sn',$order_sn)
            ->delete();
        return $res ? "200" : "404";

    }

    /*
     * 订单处理
     */
    public function handleOrder(Request $request)
    {
        $user_id = Auth::id();
        $address = DB::table('user_address')
            ->where([
                ['user_id',$user_id],
                ['is_default',1]
            ])
            ->first();
        if(!$address){
            return redirect('/home/member/addressAdd');
        }

        $datas = $request -> except('_token');
        $uid = Auth::id();//用户id
        $orderInfo = json_decode($datas['info']);
        $user_note = $datas['user_note'];
        $address = $datas['address'];
        $order_fsn = $datas['order_fsn'];
        $order_sn  = $datas['order_sn'];//var_dump($order_fsn);dd($order_sn);
        //判断订单数量
        if(count($orderInfo)>1){
            DB::beginTransaction();
            try{
                //插入第一条数据
                //$order_sn = getOrderId($uid);
                $data = [
                    'order_sn' => $order_fsn,
                    'order_fsn' => 0,
                    'pro_id' => 0,
                    'pro_attr' => '',
                    'thumbnailname' => '',
                    'filename' => '',
                    'user_id' => $uid,
                    'order_status' => 0,
                    'pay_name' => 0,
                    'pro_price' => 0,
                    'order_amount' => 0,
                    'pay_amount' => 0,
                    'addtime' => time(),
                    'user_note' => '',
                    'dis_count' => 0,
                    'table_type'=>0,
                    'demand1' => '',
                    'demand2' => ''
                ];
                $res = Orders::where('order_sn',$order_fsn)->first();
                if(empty($res)){
                    Orders::create($data);
                    $this->_orderInfo($order_fsn, $address, 0);
                }
                //遍历商品
                $pro_price = 0;
                foreach($orderInfo as $k=>$v){
                    //商品id
                    $pid = $v->proId;
                    $picName = session($uid.'_'.$pid.'_'.$v -> typeNumber.'_'.'picName');
                    if(empty($picName))
                    {
                        $field['demand1'] = '';//需求1
                        $field['demand2'] = '';//需求2
                    }else{
                        foreach ($picName as $key => $value) {
                            $pic = explode('&&', $value);
                            $pic = $pic['0'];
                            $dir = 'uploadRequire/';
                            if(!file_exists($dir))
                            {
                                mkdir($dir,0777,true);
                            }
                            copy("uploads/temp/$pic", $dir.''.$pic);
                        }
                        $field['demand1'] = $picName[0];//需求1
                        $field['demand2'] = $picName[1];//需求2
                    }
                    $proRes = getProPrice($v);
                    $pro_price += ($v->price1) * ($v->num);
                    $field['order_sn'] = $order_sn[$k];//订单编号
                    $field['order_fsn'] = $order_fsn;//父级订单编号
                    $field['pro_id'] = $v->proId;//产品id
                    $field['pro_attr'] = json_encode($v);//产品信息
                    $field['thumbnailname'] = $proRes['thumbing'];//缩略图
                    if(isset($v->filename)){
                        if(is_file(public_path('/uploads/temp/').$v->filename)){
                            if(!is_dir(public_path('/uploads/')))
                                mkdir(public_path('/uploads/'));
                            if(!is_dir(public_path('/uploads/user_file/')))
                                mkdir(public_path('/uploads/user_file/'));
                            if(!is_dir(public_path('/uploads/user_file/').$uid))
                                mkdir(public_path('/uploads/user_file/').$uid);
                            rename("uploads/temp/{$v->filename}", "uploads/user_file/{$uid}/{$v->filename}");
                        }
                        $field['filename'] = $v->filename;//文件名称
                    }
                    $field['user_id'] = $uid;//用户id
                    $field['order_status'] = 0;//订单状态
                    $field['pay_name'] = 0;//支付方式
                    $field['pro_price'] = $proRes['price'] * ($v->num);//商品总价
                    $field['order_amount'] = $field['pro_price'];//应付金额
                    $field['pay_amount'] = 0;//实付金额
                    $field['addtime'] = time();//下单时间
                    if(!empty($user_note)){
                        $field['user_note'] = $user_note;//用户备注
                    }
                    $field['dis_count'] = 0;//优惠金额
                    $field['table_type'] = $v->typeNumber;//是哪张表
                    $res = Orders::where('order_sn',$field['order_sn'])->first();
                    if(empty($res)) {
                        Orders::create($field);
                        $this->_orderInfo($field['order_sn'], $address, $field['order_amount']);
                    }
                }
                Orders::where('order_sn', $order_fsn)->update(['pro_price'=>$pro_price,'order_amount'=>$pro_price]);
                OrderInfo::where('order_sn',$order_fsn)->update(['ad_update'=>$pro_price]);
                DB::commit();
            } catch (\Exception $e){
                DB::rollback();//事务回滚
                echo $e->getMessage();
                echo $e->getCode();
            }

        }else{
            //生成订单号
            //$order_sn = getOrderId($uid);
            foreach($orderInfo as $k=>$v){
                //判断产品来自哪个表
                $pid = $v->proId;
                $proRes = getProPrice($v);
                $picName = session($uid.'_'.$pid.'_'.$v -> typeNumber.'_'.'picName');
            }
            //计算总价格
            $pro_price = $proRes['price'] * ($v->num);
            //订单插入字段
            if(empty($picName))
            {
                $field['demand1'] = '';//需求1
                $field['demand2'] = '';//需求2
            }else{
                foreach ($picName as $key => $value) {
                    $pic = explode('&&', $value);
                    $pic = $pic['0'];
                    $dir = 'uploadRequire/';
                    if(!file_exists($dir))
                    {
                        mkdir($dir,0777,true);
                    }
                    copy("uploads/temp/$pic", $dir.''.$pic);
                }
                $field['demand1'] = $picName[0];//需求1
                $field['demand2'] = $picName[1];//需求2
            }
            $field['order_sn'] = $order_sn[0];//订单编号
            $field['order_fsn'] = 0;//父级订单编号
            $field['pro_id'] = $pid;//产品id
            $field['pro_attr'] = json_encode($v);//产品信息
            $field['thumbnailname'] = $proRes['thumbing'];//缩略图
            if(isset($v->filename)){
                if(is_file(public_path('/uploads/temp/').$v->filename)){
                    if(!is_dir(public_path('/uploads/')))
                        mkdir(public_path('/uploads/'));
                    if(!is_dir(public_path('/uploads/user_file/')))
                        mkdir(public_path('/uploads/user_file/'));
                    if(!is_dir(public_path('/uploads/user_file/').$uid))
                        mkdir(public_path('/uploads/user_file/').$uid);
                    rename("uploads/temp/{$v->filename}", "uploads/user_file/{$uid}/{$v->filename}");
                }
                $field['filename'] = $v->filename;//文件名称
            }
            $field['user_id'] = $uid;//用户id
            $field['order_status'] = 0;//订单状态
            $field['pay_name'] = 0;//支付方式
            $field['pro_price'] = $pro_price;//商品总价
            $field['order_amount'] = $pro_price;//应付金额
            $field['pay_amount'] = 0;//实付金额
            $field['addtime'] = time();//下单时间
            if(!empty($user_note)){
                $field['user_note'] = $user_note;//用户备注
            }
            $field['dis_count'] = 0;//优惠金额
            $field['table_type'] = $v->typeNumber;//是哪张表
            DB::beginTransaction();
            try{
                $res = Orders::where('order_sn',$field['order_sn'])->first();
                if(!$res) {
                    $res = DB::table('orders')->insert($field);
                    $this->_orderInfo($field['order_sn'], $address, $pro_price);
                }
                DB::commit();
            } catch (\Exception $e){
                DB::rollback();//事务回滚
                echo $e->getMessage();
                echo $e->getCode();
            }
        }
        //
        return view('home/shopping/pay',['data'=>count($orderInfo)>1 ? $order_fsn :$order_sn[0]]);//直接传订单号，从订单获取金额
    }

    private function _orderInfo($order_sn, $address, $pro_price)
    {
        if(empty(OrderInfo::where('order_sn', $order_sn)->get()->toArray()))
            OrderInfo::create(['order_sn'=>$order_sn, 'address'=>$address, 'ad_update'=>$pro_price]);
    }


    /*
     * 支付页面
     */
    public function alipay($order)
    {
        //清空购物车
        Session::forget('buy');
        $alipay = new AlipayController();
        //多订单
        if(strpos($order, '_')){
            $orders = '';
            $amount = 0;
            $orderArr = explode('_', $order);
            foreach($orderArr as $v){
                $orders .= $v . '_';
                $res = Orders::select('order_amount')->where('order_sn', $v)->get()->first()->toArray();
                $amount += $res['order_amount'] + 0;
            }
            $orders = trim($orders, '_');
            $alipay->pay($orders, $amount);
        }else{
            $res = Orders::select('order_amount')->where('order_sn', $order)->get()->first()->toArray();
            $alipay->pay($order, $res['order_amount']);
        }
    }

    /**
     * 微信支付
     */
    public function wechat($order)
    {


        //清空购物车
        Session::forget('buy');
//        $WechatPay = new WechatPayController();
        //多订单
        if(strpos($order, '_')){
            $orders = '';
            $amount = 0;
            $orderArr = explode('_', $order);
            foreach($orderArr as $v){
                $orders .= $v . '_';
                $res = Orders::select('order_amount')->where('order_sn', $v)->get()->first()->toArray();
                $amount += $res['order_amount'] + 0;
            }
            $orders = trim($orders, '_');
//            $WechatPay->pay($orders, $amount);
            return view('wechat.jsapi',['money'=> $amount]);

        }else{
            $res = Orders::select('order_amount')->where('order_sn', $order)->first()->toArray();
            
            session(['money'=> $res['order_amount'],'order'=> $order]);
           return view('wechat.jsapi');

        }

    }




}
