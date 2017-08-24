<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Session;
use App\Http\Models\Ad;
use App\Http\Models\AdPosition;

use DB;
use Cookie;
use Illuminate\Support\Facades\Hash;

class IndexController extends CommonController
{
    use \Illuminate\Foundation\Auth\AuthenticatesUsers;
    /*
     * 首页
     * */
    public function index()
    {

        //向user_info表添加数据
        $user_id = Auth::id();
        if($user_id)
        {
            $res = DB::table('user_info') -> where('user_id',$user_id) ->first();
            if(!$res)
            {
                DB::table('user_info') ->insert(['user_id'=>$user_id]);
            }
        }
        //查询产品分类
        $fieldType = array('id','name','pic');
        $productType = DB :: table('pro_type')
            ->where([
                ['state','=',0]
            ])
            ->select($fieldType)
            ->get();
        $countType = count($productType);
        $i = 0;
        $j = 0;
        foreach($productType as $k => $v){
            if($j > 9){
                $i ++;
                $j = 0;
            }

            $data['productType'][$i][$k] = $v;
            $j++;

        }

        //查询今日推荐信息
        $fieldToday = array('id','thumbing','name');
        $data['productToday'] = DB :: table('recommend')
            ->where([
                ['state','=',0],
                ['show_time','<=',time()]
            ])
            ->select($fieldToday)
            ->limit(4)
            ->get();
        //var_dump($data['productToday']);die;
        //限时预购(待确定，待做)
        $fieldBuy = array('id','thumbing','name','show_time','end_time');
        $data['productBuy'] = DB :: table('pre_buy')
            ->where([
                ['state','=',0],
                ['show_time','<=',time()],
                ['end_time','>',time()]
            ])
            ->limit(5)
            ->get();

        //活动专区
        $fieldAcivity = array('id','thumbing','name');
        $data['productAcivity'] = DB :: table('activity')
            ->where('state','=',0)
            ->select($fieldAcivity)
            ->limit(3)
            ->get();

        //首页显示各类产品
        $idObject = DB :: table('pro_type')
            ->where([
                ['state','=',0],
                ['status','=',1]
            ])
            ->select('id','name')
            ->get();


        foreach($idObject as $key=>$val){
            //$idArr[] = $val['id'];

            $fieldProduct = array('id','thumbing','name');
            $dataArr = array();
            $dataObject = DB :: table('product')
                ->where([
                    ['state','=',0],
                    ['type_id','=',$val->id]

                ])
                ->select($fieldProduct)
                ->limit(5)
                ->get();
            $dataArr = array();
            $dataArr1 = array();
            foreach($dataObject as $v){
                foreach($v as $ks=>$vs){
                    $dataArr1[$ks] = $vs;
                }

                $dataArr[] = $dataArr1;

            }
            if(count($dataArr) != 0){
                $dataArr['type_name'] = $val->name;
                $dataArr['type_id'] = $val->id;
                $data['product'][] = $dataArr;
            }

        }

        $res = Ad::get()->toArray();
        foreach ($res as $key => $value){
            $res1[] = AdPosition::where('id',$value['position'])->select('alias')->first()->toArray();

        }
        $res = DB::table('ad')
            ->join('ad_position','ad.position','=','ad_position.id')
            ->select('ad_position.alias')
            ->get()
            ->toArray();

        foreach ($res as $key => $value){
            if($value->alias != 'index_banner1' && $value->alias != 'index_banner2'){
                $res2[] = $value->alias;
//            $data['product'][$key]['alias'] = $value->alias;
            }

        }

        foreach ($res2 as $kk => $vv){

            $data['product'][$kk]['alias'] = $vv;
        }
        //var_dump($data['product']);die;
        //查询合作商家
        $partner = DB::table('cooperation') -> get();


        if (!strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') === false) { 
            //微信授权
                if(isset($_GET['code'])){
                    $i = 1;
                    if($i == 1){
                        $i++;
                        if(!Auth::check()){
                            $data =  $this->wechat_auth();
                            return view('wechat.login',['name' => $data['name'],'password'=> $data['password']]);
                        }
                    }
                    if($i > 1){
                        return view('home.index',['data'=> $data,'partner' => $partner]);
                    }
                }else{
                    if($i =1 ){
                        $this->get_openid();
                    }
                }
        
        }


        //购物车数量
        $id = Auth::id();
        if(Auth::Check())
        {
            $res = Redis::get('Cart');
            $res = unserialize($res);
            if(isset($res['cart'][$id]) && !empty($res['cart'][$id]))
            {
                $cartNumber = count($res['cart'][$id]);
            }else{
                $cartNumber = '0';
            }
        }else{
            if(isset($_COOKIE['Cart']))
            {
                $res = $_COOKIE['Cart'];
                $res = unserialize($res);
                $cartNumber = count($res['cart']);
            }else{
                $cartNumber = '0';
            }
        }

//         dd($cartNumber);
        session() -> put('cartNumber',$cartNumber);




        return view('home.index',['data'=> $data,'partner' => $partner,'ad' => $res1]);
    }

    public function search(Request $request)
    {
        $where['state'] = 0;
        $fieldProduct = array('id','thumbing','name','min');
        $data = DB :: table('product')
            ->where($where)
            ->whereRaw('instr(name, \''. filter_var($request->k, FILTER_SANITIZE_STRING) .'\') > 0')
            ->select($fieldProduct)
            ->get();
        $count = count($data);
        $para['count'] = $count;
        $para['type_id'] = 0;

        //获取所有产品类别
        $whereType['state'] = 0;
        $whereType['status'] = 1;
        $proTypes = DB :: table('pro_type')
            ->where($whereType)
            ->select('id','name')
            ->get();
        $para['proType'] = $proTypes;
        $id = 0;
        //var_dump($data);die;
        return view(
            'home.product.proList',compact('data','para','id')
        );
    }


    /**
     * 获取openid
     */
    public function get_openid()
    {
        $appid = env('WECHAT_APPID');
        $secret = env('WECHAT_SECRET');
        $server_name = $_SERVER['SERVER_NAME']."/index.php";
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=" . $appid . "&redirect_uri=http://" . $server_name . "&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect";

        header("Location:$url");

//        $this->wechat_auth();

    }
     /**
     * 申请微信授权
     * [wechat_auth description]
     * @return [type] [description]
     */
    public function wechat_auth()
    {
         // appid
        $appid = env('WECHAT_APPID');
        $secret = env('WECHAT_SECRET');

        $code = $_GET['code'];

        //获取 access_token
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=". $appid ."&secret=" . $secret . "&code=" . $code . "&grant_type=authorization_code";
        $access_token_url = file_get_contents($url);    
        $access_token_url = json_decode($access_token_url);
        $openid = $access_token_url->openid;



        $access_token = $access_token_url->access_token; //获取access_token
        // 请求获取用户信息
        $user_url = "https://api.weixin.qq.com/sns/userinfo?access_token=" . $access_token . "&openid=".$openid;
        $user_info = file_get_contents($user_url);
        $user_info = json_decode($user_info);

        $data['name'] = $user_info->nickname;   //昵称
        $data['openid'] = $user_info->openid;   //openid
//        $data['sex'] = $user_info->sex;         //　
        $data1['pic'] = $user_info->headimgurl;  //用户头像

        $is_openid = DB::table('users')->where('openid',$openid)->select('openid')->first();
        if($is_openid != null){

            $rs =  DB::table('users')
                ->where('openid',$openid)
                ->update(['name'=> $data['name']]);
           DB::table('user_info')
                ->where('openid',$openid)
                ->update(['pic' => $data1['pic']]);


            $this -> wechat_login($data);
        }else{
            //首次登录
            $password = Hash::make($data['openid']);
            $id = DB::table('users')->insertGetId(['name'=>$data['name'],'openid'=>$data['openid'],'password'=> $password]);

            DB::table('user_info')
                ->insert( [
                    'user_id'=>$id,
                    'pic'=> $data1['pic'],
                    'openid'=> $data['openid']
                ] );
            $this -> wechat_login($data);
        }


        $data2['password'] = $data['openid'];
        $data2['name'] = $data['openid'];
        return $data2;
//        return redirect('/');
    }

    /**
     * 微信登录用户信息存session
     * @param $data
     */
    public function wechat_login($data)
    {
        $data['password'] = $data['openid'];
        unset($data['openid']);

        return view('wechat.login',['name' => $data['name'],'password'=> $data['password']]);

    }









}
