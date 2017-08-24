<?php

namespace App\Http\Controllers\Admin;

use App\Http\Models\Orders;
use App\Http\Models\User;
use App\Http\Models\UserAccount;
use Illuminate\Http\Request;
use Session;
use DB;

class IndexController extends CommonController
{
    //后台首页
    public function index()
    {
        $data = [
            'pt_num' => User::where('usertype','0')->count(),//普通用户数量
            'dl_num' => User::where('usertype','1')->count(),//代理商数量
            'tx_num' => UserAccount::where('state','0')->count(),//提现申请数量
            'ddz_num' => Orders::all()->count(),//订单总数
            'wzfdd_num' => Orders::where('order_status','0')->count(),//未支付订单
            'dzzdd_num' => Orders::where('order_status','1')->count(),//待制作订单
            'dfhdd_num' => Orders::where('order_status','2')->count(),//待发货订单
            'yfhdd_num' => Orders::where('order_status','3')->count(),//已发货订单
        ];
        return view('admin.index')->with('data', $data);

    }
}
