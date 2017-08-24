<?php
session_start();
ini_set('date.timezone','Asia/Shanghai');
//error_reporting(E_ERROR);
require_once '../app/wechat/lib/WxPay.Api.php';
require_once '../app/wechat/example/WxPay.JsApiPay.php';
require_once '../app/wechat/example/log.php';

//初始化日志
$logHandler= new CLogFileHandler('../app/wechat/logs/'.date('Y-m-d').'.log');
$log = Log::Init($logHandler, 15);

//打印输出数组信息
function printf_info($data)
{
    foreach($data as $key=>$value){
        echo "<font color='#00ff55;'>$key</font> : $value <br/>";
    }
}

//①、获取用户openid
$tools = new JsApiPay();
$user_id = Auth::id();
$openId = DB::table('user_info')->where('user_id',$user_id)->select('openid')->first();
$openId = $openId ->openid;
if($openId == null){
    
    $openId = $tools->GetOpenid(); //传参要这样传，还要改一下example/WxPay.JsApiPay.php文件

//    $index = new \App\Http\Controllers\Home\IndexController();
//    $index -> wechat_auth();
}


$money_old = session('money');
// if($money_old <= 0){
    
// }
$money = $money_old * 100;
//②、统一下单
$input = new WxPayUnifiedOrder();
$input->SetBody("微信支付");
$input->SetAttach("微信支付");
$input->SetOut_trade_no(WxPayConfig::MCHID.date("YmdHis"));
$input->SetTotal_fee($money);
$input->SetTime_start(date("YmdHis"));
$input->SetTime_expire(date("YmdHis", time() + 600));
$input->SetGoods_tag("test");
$input->SetNotify_url("http://temp.yinhuishangmeng.com/wechat/example/notify.php");
$input->SetTrade_type("JSAPI");
$input->SetOpenid($openId);
$order = WxPayApi::unifiedOrder($input);
// echo '<font color="#f00"><b>统一下单支付单信息</b></font><br/>';
// printf_info($order);
$jsApiParameters = $tools->GetJsApiParameters($order);

//获取共享收货地址js函数参数
// $editAddress = $tools->GetEditAddressParameters();

//③、在支持成功回调通知中处理成功之后的事宜，见 notify.php
/**
 * 注意：
 * 1、当你的回调地址不可访问的时候，回调通知会失败，可以通过查询订单来确认支付是否成功
 * 2、jsapi支付时需要填入用户openid，WxPay.JsApiPay.php中有获取openid流程 （文档可以参考微信公众平台“网页授权接口”，
 * 参考http://mp.weixin.qq.com/wiki/17/c0f37d5704f0b64713d5d2c37b468d75.html）
 */
?>

<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>微信支付</title>
    <script type="text/javascript">
        //调用微信JS api 支付
        callpay();
        function jsApiCall()
        {console.log(WeixinJSBridge);
            WeixinJSBridge.invoke(
                'getBrandWCPayRequest',
                <?php echo $jsApiParameters; ?>,
                function(res){
                    WeixinJSBridge.log(res.err_msg);
                    // alert(res.err_code+res.err_desc+res.err_msg);
                    if (res.err_msg == "get_brand_wcpay_request:ok") { //如果微信支付成功  

                        
                        window.location.href="/notify";
                        
                     }else if(res.err_msg == "get_brand_wcpay_request:cancel"){ //如果取消微信支付  

                        alert("您已取消支付");
                        window.history.back();
                      
                    }else if(res.err_msg == "get_brand_wcpay_request:fail"){
                        return view('home.shopping.payFail');
                    }   
                }
            );
        }

        function callpay()
        {
            if (typeof WeixinJSBridge == "undefined"){
                if( document.addEventListener ){
                    document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
                }else if (document.attachEvent){
                    document.attachEvent('WeixinJSBridgeReady', jsApiCall);
                    document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
                }
            }else{
                jsApiCall();
            }
        }
    </script>

</head>
<body>
<br/>
<!-- <font color="#9ACD32"><b>该笔订单支付金额为<span style="color:#f00;font-size:50px"><?php echo $money_old ?>元</span>钱</b></font><br/><br/>
<div align="center">
    <button style="width:210px; height:50px; border-radius: 15px;background-color:#FE6714; border:0px #FE6714 solid; cursor: pointer;  color:white;  font-size:16px;" type="button" onclick="callpay()" >立即支付</button>
</div> -->
</body>
</html>