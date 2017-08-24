<?php

namespace App\Http\Controllers;

use Omnipay\Omnipay;
use DB;

class WechatPayController extends Controller
{
    protected $gateway = null;

    public function __construct()
    {
        if($this->gateway == null){
            /**
            WechatPay (Wechat Common Gateway) 微信支付通用网关
            WechatPay_App (Wechat App Gateway) 微信APP支付网关
            WechatPay_Native (Wechat Native Gateway) 微信原生扫码支付支付网关
            WechatPay_Js (Wechat Js API/MP Gateway) 微信网页、公众号、小程序支付网关
            WechatPay_Pos (Wechat Micro/POS Gateway) 微信刷卡支付网关
             */
            $this->gateway    = Omnipay::create('WechatPay_Js');
            $this->gateway->setAppId('wx426b3015555a46be');
            $this->gateway->setMchId('1900009851');
            $this->gateway->setApiKey('8934e7d15453e97507ef794cf7b0519d');
            $this->gateway->setNotifyUrl(url('wechat_pay/notify'));
            $this->gateway->setTradeType('NATIVE');//JSAPI、NATIVE、APP
            $this->gateway->setCertPath(resource_path('key').'apiclient_cert.pem');
            $this->gateway->setKeyPath(resource_path('key').'apiclient_key.pem');
            
        }
    }

    public function pay($order,$order_amount)
    {

        $order = [
            'body'              => 'The test order',
//            'out_trade_no'      => date('YmdHis').mt_rand(1000, 9999),
            'out_trade_no'      => $order,
            'total_fee'         => $order_amount*100, //=0.01
            'spbill_create_ip'  => get_client_ip(),
            'fee_type'          => 'CNY',
            //'open_id' => cookie('open_id')//demo中没有这个值，但是没有会报错，不知道正式环境 有没有问题
        ];

        $request  = $this->gateway->purchase($order);
        $response = $request->send();
        $response->isSuccessful();
        $response->getData(); //For debug
        //$response->getAppOrderData(); //For WechatPay_App
        $response->getJsOrderData(); //For WechatPay_Js
        $response->getCodeUrl(); //For Native Trade Type

    }

    public function notify()
    {
        // $response = $this->gateway->completePurchase([
        //     'request_params' => file_get_contents('php://input')
        // ])->send();

        // if ($response->isPaid()) {
        //     //pay success
        //     var_dump($response->getData());die;
        // }else{
        //     //pay fail
        // }
       $order = session('order');
       $res = DB::table('orders')->where('order_sn',$order)->select('order_amount')->first();
       
       $res1 = DB::table('orders')->where('order_sn',$order)->update(['pay_amount'=> $res->order_amount, 'pay_name'=> 2, 'order_status'=> 1]);


        return view('home.shopping.paySuccess');
    }


}
