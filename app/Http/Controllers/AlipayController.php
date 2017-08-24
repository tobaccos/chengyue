<?php

namespace App\Http\Controllers;

use App\Http\Models\OrderInfo;
use App\Http\Models\Orders;
use App\Http\Models\Rechange;
use App\Http\Models\UserInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Omnipay\Omnipay;

class AlipayController extends Controller
{
    protected $gateway = null;

    public function __construct()
    {
        if($this->gateway == null){
            $this->gateway = Omnipay::create('Alipay_AopWap');
            $this->gateway->setAppId('2016080300156709');
            $this->gateway->setPrivateKey('MIIEpAIBAAKCAQEA4j80nePF9dj1YiWvr5mSb/lCp9jG616O6pTzo1gEEpIr9D2P+OtOBZTjIFMxRW0uXncujOGzwjFM6VfTemVIcTdeAomXKd/YToFe0GqmeR/NdISg8YddY2gcknbh1GjuUDWU8lCjo1awnBnkRcvUiakxGYNaHj5AGT0tY6Zauvc/ufNqawa5FvSKi2hAdqq8Pq2fSDRihsXUrPcpxMo59bjTgqvB9lCSkFc1NjuvKKnZMHnoEC9waBDjt7OWgy5Gx4x2mck9VGjQNUlimYJfI+8vQTy6W2KPSSopJIIelKH3HX525koqx9Xo7f6DZV+dPshyeu76ocIgfrkAD2QaJQIDAQABAoIBAQCGE5rk7rTECvzwWxEQaVwky3y653aKyZC8Z+UyqdhQARvXNBx8EUY9fIxU/bg3Qoq2JL8Lcj4LGRhROGD1KcySe5NUwaE5iZQwge5kaK+bHEOvh2GxgNzRKkO0cItIS57fHcHVEADJrXggKh/jVPXxVrjoO7VOMundiym44j7miL6Q7fKeT/YCRAybcG4FwYOgPsb78rsS9hPooFjxTnhWN6+K79M6ER5uA6gW7MWHhYaRfnrLBXPHVsrBA2jNUyByMibekCevkTT6IFHELRWD4ThmyoBb7yLsI//I/Yw7jUw7C0I2BUzmZokc7MEqrhXaddhJN5ULNAg31rEuiItBAoGBAPOnOIQLKhcDy9qNjQFwOkc3jb72uo1jOvy5zbiF6V9s2Swgn5cUzbPzPg80SQair4WE6YgwUGsvMBv6T2mfV2TvDpPg37qYw7Rf5l4HYvKzAJBzh9dwJEeXIVRKFnDEr70Qrk/P4q1iyv73TUijsuTBTYr+Zqarnw91s6dRSoP9AoGBAO22LqmZajPt/usHP8G059v9BhGvBivzYJzfUeCaulk7SrAbI/mQa6avHmhkqAALCiwTM5dFyXzClWLg03eX0E4wD+7ETwSS51l7Qm4mX23OSf1WqJDg4oH+yvbb1emTnGF3AVfehl8WytJRJDlSxXYpvm+HFGvvpNSNejGYIoNJAoGAXgElT+SSz6BaVS8JuQVYpsNrP8MnhIdFad4x3cBkorl3LIxFpl+TYZs2VV1h01qPB5+ZDj89t6zUDedMHj8o07tbz3gSOYbY8s2RLrQA3Axt6k14mokcpjZL2J5g/A8WkoZOCmL1XNnh4e799UmbKqDdzwOKDUHns2pA7wvxCO0CgYEAr8oHTfKfAFIjLwmIU6aFxECkSVWGmd/8dWYMta2W20Ampn8bpoXvpi9grFCrkISZfCijAV5hd3qqYJnkqE9Dg161mZvg14APyDOH189WyOxB+TApriIwP3P+AnpmAbrgbY9FFgcAlbdUPB43TJDyZ8TNCMr7BisNWQZa8+wOsckCgYAr7lmR4hhpitbVjuTQXeIW9FQ3QtTGwTjn7407yrirj6s8wPqXlvPMolcV3by3raYqKn974aKNRr6EMFjMAoNRJTxX3zXDh6QglfKU/WxdR8nCjD3DfW6S6ZIrAXhpv4fHCGFG+QuNyenrH6UDKHE239ckgY5W5tkZvT+uLYYnQA==');
            $this->gateway->setAlipayPublicKey('MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDIgHnOn7LLILlKETd6BFRJ0GqgS2Y3mn1wMQmyh9zEyWlz5p1zrahRahbXAfCfSqshSNfqOmAQzSHRVjCqjsAw1jyqrXaPdKBmr90DIpIxmIyKXv4GGAkPyJ/6FTFY99uhpiq0qadD/uSzQsefWo0aTvP/65zi3eof7TcZ32oWpwIDAQAB');
            $this->gateway->setNotifyUrl(url('alipay/notify'));
            $this->gateway->setReturnUrl(url('alipay/notify'));
            $this->gateway->setEnvironment('sandbox');//production
        }
    }
    public function pay($out_trade_no, $total_amount, $subject = '商品支付'){
        $request = $this->gateway->purchase();
        $request->setBizContent([
            'out_trade_no' => $out_trade_no,//date('YmdHis') . mt_rand(1000, 9999),//订单号
            'total_amount' => $total_amount,//0.01,//总金额
            'subject'      => $subject,//'test',//订单标题
            'product_code' => 'QUICK_WAP_PAY',
        ]);

        /**
         * @var AopCompletePurchaseResponse $response
         */
        $response = $request->send();

        $redirectUrl = $response->getRedirectUrl();
//or
        $response->redirect();
    }

    public function notify()
    {
        $request = $this->gateway->completePurchase();
        $request->setParams(array_merge($_POST, $_GET)); //Don't use $_REQUEST for may contain $_COOKIE

        try {
            $response = $request->send();

            if($response->isPaid()){
                //dump($response->data());die;
                /*
                 *
                 * array:13 [▼
                      "total_amount" => "0.01"
                      "timestamp" => "2017-05-07 17:31:34"
                      "sign" => "RjNetVupe2GV1Qa7PRSh7rvHEVdvvhtE6II1+VNWSOtjzQrmY2sxl7jXMiqwHyZQO0c1or6PZ+ML+rse7NfvXNWu1rSqPagYmSb0hN2C6dvkmhVrWIMdCKdJQvTYiUCvfPJC42qvOvX2/72DA3aFJAU8pzrL2XqJGn9glY9ABE0= ◀"
                      "trade_no" => "2017050721001004130200110726"
                      "sign_type" => "RSA"
                      "auth_app_id" => "2016080300156709"
                      "charset" => "UTF-8"
                      "seller_id" => "2088102169749612"
                      "method" => "alipay.trade.wap.pay.return"
                      "app_id" => "2016080300156709"
                      "out_trade_no" => "201705070931154680"
                      "version" => "1.0"
                      "trade_status" => "TRADE_SUCCESS"
                    ]
                 * */
                $res = $response->data();
                //多订单
                if(strpos($res['out_trade_no'], '_') !== false){
                    $orderArr = explode('_', $res['out_trade_no']);
                    foreach($orderArr as $v){
                        $order = Orders::select('pay_amount')->where('order_sn', $v)->get()->first()->toArray();
                        $this->_setOrderInfo($v,$order['pay_amount']);
                    }
                }else{
                    //用户充值的订单
                    if(strpos($res['out_trade_no'], 'MR') === 0){
                        $recharge_sn = substr($res['out_trade_no'], 2);
						$rec = Rechange::where('recharge_sn', $recharge_sn)->where('state',0)->first();							
						if(!empty($rec)){							
							UserInfo::where('user_id',$rec->user_id)->increment('virtualcurrency',$rec->money);
							Rechange::where('recharge_sn', $recharge_sn)->update(['pay_type'=>0, 'state'=>1]);							
						}
                    }else{
                        $this->_setOrderInfo($res['out_trade_no'],$res['total_amount']);
                    }
                }
                //die('支付成功'); //The notify response should be 'success' only
                return view('home.shopping.paySuccess');
            }else{
                return view('home.shopping.payFail');
                //die('支付失败'); //The notify response
            }
        } catch (Exception $e) {
            die('支付发生错误'); //The notify response
        }
    }

    //更新订单信息
    private function _setOrderInfo($order_sn, $total_amount)
    {
        //
        $orderField = ['id','order_sn','order_fsn','pro_id','table_type','pro_attr','order_amount'];
        //
        Orders::where('order_sn', $order_sn)->update(['order_status'=>'1','pay_name'=>'0', 'pay_amount'=>$total_amount]);
        OrderInfo::where('order_sn', $order_sn)->update(['ad_update'=>$total_amount]);
        //更新销量
        $orderPro = Orders::select($orderField)->where('order_sn', $order_sn)->first()->toArray();
        if($orderPro['pro_id'] == 0){
            //查找子订单
            $orderPro = Orders::select($orderField)->where('order_fsn', $order_sn)->get()->toArray();
            foreach($orderPro as $v){
            	//
				Orders::where('order_sn', $v['order_sn'])->update(['order_status'=>'1','pay_name'=>'0', 'pay_amount'=>$v['order_amount']]);
				OrderInfo::where('order_sn', $v['order_sn'])->update(['ad_update'=>$v['order_amount']]);
				//
                $op = Orders::select($orderField)->where('order_sn', $v['order_sn'])->first()->toArray();
                $this->_setVolume($op['table_type'],$op['pro_id'],$op['pro_attr']);
            }
        }else{
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
