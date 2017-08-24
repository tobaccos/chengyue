<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Session;
use DB;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use phpDocumentor\Reflection\Types\Null_;


class CartController extends Controller
{
    use AuthenticatesUsers;
    //
    public function cart(Request $request)
    {

//        return 1;
        $arr = $request->except('s');

        $userId = Auth::id();
        $res = false;
//        $cookie = false;
        //判断是否登录
        if($userId)
        {
            //判断是否有未登录购物车商品
            if(isset($_COOKIE['Cart']))
            {
                $cookie = $_COOKIE['Cart'];
                $cookie = unserialize($cookie);
                return $this -> cookie($cookie);
            }

            $res = Redis::get('Cart');
            //判断购物车是否存在
            if($res)
            {
                //购物车存在
                $res = unserialize($res);
                if(!$res)
                {
                    //购物侧不存在
                    $res['cart'][$userId][] = $arr;
                    $res['cart'][$userId][0]['datas']['num'] = 1;
                    $res = serialize($res);
                    Redis::set('Cart',$res);
                    return "200";
                }
                if(array_key_exists($userId,$res['cart']))
                {
                    return $this -> is_exists($res,$arr);
                }
                //购物侧不存在
                $res['cart'][$userId][] = $arr;
                $res['cart'][$userId][0]['datas']['num'] = 1;
                $res = serialize($res);
                Redis::set('Cart',$res);
                return "200";



            }else{

                //购物侧不存在
                $res['cart'][$userId][] = $arr;
                $res['cart'][$userId][0]['datas']['num'] = 1;
                $res = serialize($res);
                Redis::set('Cart',$res);
//                return "登陆后首次加入购物车，加入购物车成功";
                return "200";
            }

        }else {
            //没有登录

            if(isset($_COOKIE['Cart']))
            {
                $res = $_COOKIE['Cart'];

            }
            if ($res) {
                $res = unserialize($res);
                $cartNum = $res['cart'] ? count($res['cart']) - 1 : 0;
                foreach ($res['cart'] as $key => $value) {
                    $Ucart = $value['datas'];
                    $attrNameVal = $Ucart['attrNameVal'];//购物车单选属性
                    $Attrkeys = array_keys($attrNameVal);//获取单选属性键名
                    $Attr = $arr['datas']['attrNameVal'];   //新添加的单选属性
                    $newAttr_keys = array_keys($arr['datas']['attrNameVal']);   //新添加的单选属性键名
                    //多选属性遍历
                    $checkboxAttr = array_key_exists('selfAttrObject', $Ucart) ? $Ucart['selfAttrObject'] : "";
                    //新的多选属性
                    $newCheck = array_key_exists('selfAttrObject', $arr['datas']) ? $arr['datas']['selfAttrObject'] : "";
                    $new_proId = $arr['datas']['proId'];
                    $old_proId = $Ucart['proId'];
                    if($new_proId == $old_proId)
                    {

                        $attr_bool = array_diff($attrNameVal, $Attr);
                        $attr_bool2 = array_diff($Attrkeys, $newAttr_keys);
                        if ($attr_bool == false && $attr_bool2 == false) {
                            //说明单选和购物车一致
                            //判断多选是否一致
                            if ($checkboxAttr != "" && $newCheck != "") {
                                if (count($newCheck) == count($checkboxAttr)) {
                                    //判断多选属性键值是否一致
                                    $oldCheak_keys = array_keys($checkboxAttr);
                                    $newCheak_keys = array_keys($newCheck);
                                    $check_bool = array_diff($newCheck, $checkboxAttr);
                                    $check_bool2 = array_diff($newCheak_keys, $oldCheak_keys);
                                    if ($check_bool == false || $check_bool2 == false) {
                                        //多选属性一致，购物车加1
                                        $res['cart'][$cartNum]['datas']['num'] += 1;
                                        $res = serialize($res);
                                        setcookie('Cart', $res,time()+60*60*24,'/');
//                                            return "没有登录多选属性一致=单选属性一致，购物车加1";
                                        return "200";
                                    }
                                }
                            }
                            if ($checkboxAttr == "" && $newCheck == "") {
                                //购物车多选为空
                                $res['cart'][$cartNum]['datas']['num'] += 1;
                                $res = serialize($res);
                                setcookie('Cart', $res,time()+60*60*24,'/');
//                                    return "没有登录多选属性都为空=单选属性一致，购物车加1";
                                return "200";

                            }

                        }
                    }


                }
                //单选属性不一致，添加购物车成功 没有登录
                $cartNum++;
                $res['cart'][$cartNum] = $arr;
                $res['cart'][$cartNum]['datas']['num'] = 1;
                $res = serialize($res);
                setcookie('Cart', $res,time()+60*60*24,'/');
                return "200";
            }
            //购物车中没有 没登录 首次添加
            $res = array();
            $res['cart'][] = $arr;
            $res['cart'][0]['datas']['num'] = 1;
            $res = serialize($res);
            setcookie('Cart', $res,time()+60*60*24,'/');
            return "200";

        }

    }

    /*
     * 购物车中已存在
     * $res  购物车中商品
     * $arr  新添加购物车商品信息
     */
    public function is_exists($res,$arr)
    {
        $userId = Auth::id();
        sort($res['cart'][$userId]);
        $Ucart = $res['cart'][$userId];

        $cartNum = $res['cart'][$userId] ? count($res['cart'][$userId]) - 1 : 0;

        foreach ($Ucart as $key => $value)
        {
            //判断类型是否一致
            if($value['datas']['typeNumber'] == $arr['datas']['typeNumber'])
            {
                $attrNameVal = $value['datas']['attrNameVal'];//单选属性
                $Attrkeys = array_keys($attrNameVal);//获取单选属性键名
                $Attr = $arr['datas']['attrNameVal'];//新的单选属性
                $newAttr_keys = array_keys($Attr);//获取单选属性键名
                //多选属性遍历
                $checkboxAttr = array_key_exists('selfAttrObject', $value['datas']) ? $value['datas']['selfAttrObject'] : "";
                //新的多选属性
                $newCheck = array_key_exists('selfAttrObject', $arr['datas']) ? $arr['datas']['selfAttrObject'] : "";
                $attr_bool = array_diff($attrNameVal, $Attr);
                $attr_bool2 = array_diff($Attrkeys, $newAttr_keys);

                $new_proId = $arr['datas']['proId'];
                $old_proId = $value['datas']['proId'];
                if($new_proId == $old_proId)
                {
                    if ($attr_bool == false && $attr_bool2 == false) {
                        //单选属性购物车存在
                        if ($checkboxAttr != "" && $newCheck != "") {
                            if (count($newCheck) == count($checkboxAttr)) {
                                //判断多选属性键值是否一致
                                foreach ($newCheck as $k => $val)
                                {
                                    $oldAttr[] = explode("_",$checkboxAttr[$k]);//购物车多选属性
                                    $newAttr[] = explode("_",$newCheck[$k]);    //新的多选属性

                                }

                                if (serialize($oldAttr) == serialize($newAttr)) {
                                    //多选属性一致，购物车加1
                                    $res['cart'][$userId][$key]['datas']['num'] += 1;
                                    $res = serialize($res);
                                    Redis::set('Cart', $res);
//                                        return "登录hou多选属性一致=单选属性一致，购物车加1";
                                    return "200";
                                }
                            }
                        }
                        //购物车多选为空
                        if ($checkboxAttr == "" && $newCheck == "") {
                            //多选属性不一致，购物车加1
                            $res['cart'][$userId][$key]['datas']['num'] += 1;
                            $res = serialize($res);
                            Redis::set('Cart', $res);
//                                return "登录hou多选属性都为空=单选属性一致，购物车加1";
                            return "200";

                        }
                    }
                }
            }



        }

        //购物车不存在
        $cartNum ++;
        $res['cart'][$userId][$cartNum] = $arr;
        $res['cart'][$userId][$cartNum]['datas']['num'] = 1;
        $res = serialize($res);
        Redis::set('Cart',$res);
//                return "登录后，属性不一致，新加入购物车成功";
        return "200";


    }

    /*
     * 购物车展示
     */
    public function cart_list()
    {
        if(!Redis::get('Cart'))
        {
            return view('home.shopping.shopCart') ->with(['info'=> "购物车没有商品"]);
        }

        $userId = Auth::id();
        $res = Redis::get('Cart');
        $res = unserialize($res);
        if(isset($res['cart'][$userId]))
        {
            $Ucart = $res['cart'][$userId];
            if($Ucart)
            {
                foreach ($Ucart as $key => $value)
                {
                    $pro_id = $value['datas']['proId'];
                    //  产品列别id
                    $typeNumber = $value['datas']['typeNumber'];
                    switch ($typeNumber)
                    {
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
                    //产品信息
                    $product = DB::table($table)
                        ->where('id',$pro_id)
                        ->first();

                    //类型
                    $pro_type = DB::table('pro_type')
                        ->where('id',$product->type_id)
                        ->select('name','id')
                        ->first();
//

                    $data[$key] = $Ucart[$key]['datas'];
                    $data[$key]['pro_name'] = $product->name;
                    $data[$key]['pro_type'] = $pro_type->name;
                    $data[$key]['type_id'] = $pro_type->id;
                    $data[$key]['del_id'] = $key;
                    $data[$key]['pro_img'] = $product -> thumbing;
                    //判断错选属性是否存在
                    if(isset($value['datas']['selfAttrObject']))
                    {
                        $data[$key]['selfAttrObject'] = json_encode($value['datas']['selfAttrObject']);
                    }
                    if(isset($value['datas']['attrNameVal']))
                    {
                        $data[$key]['attrNameVal'] = json_encode($value['datas']['attrNameVal']);
                    }

//
                }

                //将产品分类
                $re = array();
                foreach($data as $k =>$item) {
                    $re[$item['type_id']][] = $item;
                }
                $re = array_merge($re);

//                foreach ($re as $k => $v)
//                {
//                    foreach ($v as $keys => $val)
//                    {
//                        $thumbimg = DB::table($table)
//                            ->where('id',$val['proId'])
//                            ->select('thumbing')
//                            ->first();
//                        $re[$k][$keys]['pro_img'] = $thumbimg->thumbing;
//
//                        if(isset($val['selfAttrObject']))
//                        {
//                            $re[$k][$keys]['selfAttrObject'] = json_encode($val['selfAttrObject']);
//                        }
//                        $re[$k][$keys]['attrNameVal'] = json_encode($val['attrNameVal']);
//
//                    }
//                }
            }else{
                $re = array();
            }
        }else{
            $re = array();
        }


//dd($re);
        return view('home.shopping.shopCart',['data'=> $re]);
    }

    /*
     * 删除购物车中商品
     */
    public function cart_del(Request $request)
    {
        $user_id = Auth::id();
        //要删除的购物车中商品id
        $cart_id = $request->only('id');
        $cart_id = $cart_id['id'];
//        $cart_id = 0;
        $res = Redis::get('Cart');
        $res = unserialize($res);

        if($res)
        {
            $cart = $res['cart'][$user_id];
            if(array_key_exists($cart_id,$cart))
            {

                unset($cart[$cart_id]);
                $res['cart'][$user_id] = $cart;
                $res = serialize($res);
                Redis::set('Cart',$res);
                return "200";
            }
            return "404";
        }

    }
}
