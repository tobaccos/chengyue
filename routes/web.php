<?php



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/home/shopping/paySuccess', function () {
    return view('home.shopping.paySuccess');//支付成功页
});
Route::get('/home/shopping/payFail', function () {
    return view('home.shopping.payFail');//支付失败页
});
Route::get('wkey', function () {
    return view('welcome');//支付成功页
});
Auth::routes();
Route::get('/logout',function (){
   Auth::logout();
   return redirect('/login');
});
//冻结金提现前台
Route::get('/home/member/appcash',function (){
   return view('home.member.appcash');
});
Route::any('/wechat/{order}', 'Home\OrderController@wechat');
Route::any('/notify', 'WechatPayController@notify');
Route::any('/wechat', 'Home\OrderController@notify');

Route::group(['middleware' => 'wkey','namespace'=>'Home'], function () {
    Route::get('/', 'IndexController@index');//首页
    Route::get('home/index', 'IndexController@index');//首页
    Route::get('home/product/proList/{id}', 'ProductController@proList');//产品列表页
    Route::get('home/product/proDetail/{id}/{number}', 'ProductController@detail');//产品列表页
    Route::post('home/product/sort', 'ProductController@sort');//产品列表页排序操作
    Route::post('home/product/sortCheck', 'ProductController@sortCheck');//产品列表页筛选属性
    Route::post('home/product/collect', 'ProductController@collect');//产品收藏
    Route::post('home/product/upload/{id}', 'ProductController@upload');//产品收藏
    Route::get('home/shopping/order', 'OrderController@order');//订单显示提交页面
    Route::post('home/shopping/cart_to_order', 'OrderController@cartToOrder');//购物车提交订单
    Route::post('home/shopping/member_to_order', 'OrderController@memberToOrder');//个人中心提交订单
    Route::post('home/shopping/buy', 'OrderController@buy');//立即购买临时存放
    Route::post('home/shopping/handleOrder', 'OrderController@handleOrder');//处理订单并支付
    Route::get('home/product/sorts', 'ProductController@sorts');//产品列表页

	Route::get('home/shopping/alipay/{order}', 'OrderController@alipay');
    Route::any('home/shopping/vpay/{order}', 'RechangeController@pay');//余额支付
//	Route::get('/home/member/self', function () {
//    return view('home.member.self');//我的订单
//	});
//	Route::get('/home/member/usermanger', function () {
//    return view('home.member.usermanger');//账户管理
//	});
	Route::any('/home/member/withdrawals', 'RechangeController@recharge');
	Route::get('/home/member/price', 'RechangeController@price');
	Route::get('/home/member/reviewssuccess', function () {
    return view('home.member.reviewssuccess');//评价成功
	});
	Route::get('/home/member/proinfo1', function () {
    return view('home.member.proinfo1');
	});
	Route::get('/home/member/setzhi', function () {
    return view('home.member.setzhi');
	});
	Route::get('/home/shopping/less', function () {
    return view('home.shopping.less');//余额不足以支付
	});
	Route::get('/home/member/email', function () {
    return view('home.member.email');
	});
	Route::get('/emails/test', function () {
    return view('emails.test');
	});
	Route::get('/emails/resetPayPass', function () {
    return view('emails.resetPayPass');
	});
	Route::get('/emails/reset', function () {
    return view('emails.reset');
	});

//	Route::get('/home/member/rebate', function () {
//    return view('home.member.rebate');
//	});
});

// Route::get('home/product/uploadRequire',function (){
//     return view('home/product/uploadRequire');
// });


//Route::get('/Home/index','Home\IndexController@index');
Route::group(['middleware' => ['home','wkey'],'namespace' => 'Home'], function(){
    Route::get('/home/member/changepass', function () {
        return view('home.member.changepass');//
    });
	Route::get('/home/shopping/payAddress','UserController@payAddress');//订单详情选择默认地址
	Route::get('/home/shopping/paychange', function () {
        return view('home.shopping.paychange');//订单详情添加地址
    });
    Route::post('passUpdate','UserController@passUpdate' );             //执行修改密码
    Route::post('payPassUpdate','UserController@payPassUpdate' );       //修改支付密码
    Route::post('setPayPass','UserController@setPayPass' );             //设置支付密码
    Route::get('/home/member/myInfo','UserController@index');           //个人中心
    Route::get('/home/member/personal', 'UserController@personal');     //个人信息
    Route::get('/home/member/usermanger', 'UserController@usermanger'); //账户管理
    Route::get('/home/member/rebate', 'RebateController@rebate');       //返利记录
    Route::post('/home/member/rebate', 'RebateController@rebate');      //返利记录
    Route::post('/home/member/rebateDel', 'RebateController@rebateDel');//删除返利记录
    Route::post('/home/member/cash', 'RebateController@cash');          //提现
    Route::get('/home/member/cash','RebateController@index');           //返利体现页面
    Route::get('/home/member/areaApp', function () {
        return view('home.member.areaApp');//代理商申请
    });
    Route::match(['get','post'],'/home/member/areaApp','UserController@areaApp');//代理商申请

    Route::post('/home/member/reviews', 'ProductController@reviews');           //商品评价
    Route::post('/home/member/collect_del', 'ProductController@collect_del');   //删除收藏
    Route::post('/home/member/proReviews', 'ProductController@proReviews');     //商品评价
    Route::get('/home/member/reviewssuccess', function () {
        return view('home.member.reviewssuccess');
    });
    //修改支付密码
    Route::get('/home/member/xiugai', function () {
        return view('home.member.xiugai');
    });
    //编辑
    Route::post('/home/member/addressEdite', 'UserController@addressEdite');//编辑收货地址
    Route::match(['get','post'],'/home/member/addressAdd', 'UserController@addressAdd');//添加收货地址
    Route::get('/home/member/address', 'UserController@address');       //管理收货地址 1
    Route::post('/home/member/addressUpdate', 'UserController@update');  //更改收货地址
    Route::post('/home/member/delete', 'UserController@delete');        //删除收货地址
    Route::post('/home/member/default', 'UserController@default');      //默认收货地址
//    Route::get('/home/member/addressEdite', function () {
//        return view('home.member.addressEdite');
//    });
    Route::get('/home/member/recharge', 'UserController@recharge');                //用户充值
    Route::post('/home/member/recharge', 'UserController@recharge');               //用户充值
    Route::post('/home/member/uploadImage', 'UserController@uploadImage');         //用户头像上传
    Route::get('/home/shopping/shopCart','CartController@cart_list');              //购物车列表
    Route::post('/home/shopping/cart_del','CartController@cart_del');              //删除购物车中商品
    Route::get('/home/member/myfavorite', 'ProductController@myfavorite');         //我的收藏
    Route::get('/home/member/orderList', 'OrderController@orderList');             //订单列表
    Route::get('/home/member/proinfo/{order_sn}', 'ProductController@proinfo');   //订单详情
    Route::get('/home/member/set', 'UserController@set');                            //用户充值
    Route::post('/home/member/email', 'UserController@email');                       //绑定邮箱
    Route::post('/home/member/phone', 'UserController@phone');                       //绑定手机
    Route::post('/home/member/QQ_add', 'UserController@QQ_add');                     //绑定QQ
    Route::post('/home/member/userNameUpdate', 'UserController@userNameUpdate');   //修改用户昵称                //绑定QQ
    Route::post('/home/member/confirm', 'OrderController@confirm');                 //确认收货
    Route::post('/home/member/order_del', 'OrderController@order_del');             //删除订单
    //上传需求
    Route::get('home/product/uploadRequire/{id}/{number}','UploadController@index');
    Route::post('home/product/uploadRequire','UploadController@upload');



});
//支付
    Route::get('/resetPayPass', 'Home\ResetPayController@index'); //找回支付密码
    Route::post('/toReset', 'Home\ResetPayController@toReset');    //找回密码
    Route::get('/resetView/{token}', 'Home\ResetPayController@resetView'); //重置支付密码页面
    Route::post('/resetPay', 'Home\ResetPayController@resetPay'); //重置支付密码
//    Route::post('/reset', 'Home\ResetPayController@reset'); //找回支付密码
//Route::get('/test', 'Home\ResetPayController@test'); //找回支付密码
    Route::post('/send', 'Home\ResetPayController@send');    //找回支付密码

Route::group(['middleware' => 'wkey','namespace'=>'Home'], function () {

    Route::get('/', 'IndexController@index');
    Route::get('search', 'IndexController@search');


    //限时
    Route::get('/home/product/timeLimit','ProductController@timeLimit');//限时
    Route::post('/home/product/totimeLimit','ProductController@totimeLimit');//限时
    Route::get('/home/product/recommend', 'ProductController@recommend');//今日推荐
    Route::post('/home/product/torecommend', 'ProductController@torecommend');//今日推荐
    Route::get('/home/product/proActive','ProductController@proActive');//活动
    Route::post('/home/product/toproActive','ProductController@toproActive');//活动



    Route::post('/home/shopping/cart','CartController@cart');   // 加入购物车


    Route::get('/home/member/intro',function (){
        return view('home.member.intro');// 关于我们
    });
    Route::get('/aaa','CartController@cart');

    Route::post('/home/member/dls_apply', 'UserController@dls_apply');


    });
Route::get('kit/captcha/{tmp}', 'KitController@captcha');   // 验证码
Route::get('/home', 'HomeController@index');
Route::get('/toRebate', 'Home\RebateController@toRebate');
//Route::get('/toRebate', 'RebateController@toRebate');
//alipay
//Route::get('alipay', 'AlipayController@pay');
Route::any('alipay/notify', 'AlipayController@notify');
Route::get('wechat_pay', 'WechatPayController@pay');
Route::any('wechat_pay/notify', 'WechatPayController@notify');
//后台登陆
Route::match(['get','post'],'admin/login','Admin\LoginController@login');
//后台退出登录
Route::get('admin/logout','Admin\LoginController@logout');
////后台中间件
Route::group(['middleware' => 'Login'],function() {

    Route::group(['middleware' => ['web'],'prefix'=>'admin','namespace'=>'Admin'], function () {
        Route::get('/', 'IndexController@index');
        //配置
        Route::get('config/index', 'ConfigController@index');
        Route::post('config/update', 'ConfigController@update');
        //分类
        Route::resource('category', 'CategoryController');
        Route::post('category/sort', 'CategoryController@sort');
        //属性
        Route::resource('pro_attr', 'ProAttrController');
        Route::post('pro_attr/dels', 'ProAttrController@dels');
        //活动
        Route::resource('activity', 'ActivityController');
        Route::post('activity/dels', 'ActivityController@dels');
        Route::post('activity/copy/{copy_id}', 'ActivityController@copy');
        //推荐
        Route::resource('recommend', 'RecommendController');
        Route::post('recommend/dels', 'RecommendController@dels');
        Route::post('recommend/copy/{copy_id}', 'RecommendController@copy');
        //限时
        Route::resource('pre_buy', 'PreBuyController');
        Route::post('pre_buy/dels', 'PreBuyController@dels');
        Route::post('pre_buy/copy/{copy_id}', 'PreBuyController@copy');
        //产品
        Route::resource('product', 'ProductController');
        Route::post('product/ajaxAttrAdd', 'ProductController@ajaxAttrAdd');
        Route::post('product/dels', 'ProductController@dels');
        Route::post('product/copy/{copy_id}', 'ProductController@copy');
        //产品属性组合
        Route::resource('pro_com', 'ProComController');
        Route::post('pro_com/dels', 'ProComController@dels');
        Route::get('pro_com/show/{id}', 'ProComController@show');
        Route::get('pro/getAjaxComCate', 'ProductController@getAjaxComCate');
        Route::get('pro/getAjaxCom/{id}', 'ProductController@getAjaxCom');
        Route::post('pro/uploadify/{pathType}', 'ProductController@uploadify');
    });

    Route::group(['middleware' => ['web'], 'prefix' => 'admin', 'namespace' => 'Admin'], function () {
        Route::get('/', 'IndexController@index');
        //配置
        Route::get('config/index', 'ConfigController@index');
        Route::post('config/update', 'ConfigController@update');
        //分类
        Route::resource('category', 'CategoryController');
        //属性
        Route::resource('pro_attr', 'ProAttrController');
        Route::post('pro_attr/dels', 'ProAttrController@dels');
        //活动
        Route::resource('activity', 'ActivityController');
        Route::post('activity/dels', 'ActivityController@dels');
        //推荐
        Route::resource('recommend', 'RecommendController');
        Route::post('recommend/dels', 'RecommendController@dels');
        //限时
        Route::resource('pre_buy', 'PreBuyController');
        Route::post('pre_buy/dels', 'PreBuyController@dels');
        //产品
        Route::resource('product', 'ProductController');
        Route::post('product/ajaxAttrAdd', 'ProductController@ajaxAttrAdd');
        Route::post('product/dels', 'ProductController@dels');
        //产品属性组合
        Route::resource('pro_com', 'ProComController');
        Route::post('pro_com/dels', 'ProComController@dels');
        Route::get('pro_com/show/{id}', 'ProComController@show');
        Route::get('pro/getAjaxComCate', 'ProductController@getAjaxComCate');
        Route::get('pro/getAjaxCom/{id}', 'ProductController@getAjaxCom');
        Route::post('pro/uploadify', 'ProductController@uploadify');
        //广告管理
        Route::get('ad/index', 'AdController@index');
        Route::any('ad/add', 'AdController@add');
        Route::any('ad/edit/{id}', 'AdController@edit');
        Route::post('ad/del/{id}', 'AdController@del');
        Route::get('ad/position', 'AdController@position');
        Route::any('ad/pos_add', 'AdController@pos_add');
        Route::any('ad/pos_edit/{id}', 'AdController@pos_edit');
        Route::post('ad/pos_del/{id}', 'AdController@pos_del');
    });

    Route::get('admin/index', 'Admin\IndexController@index');



    //管理员模块
    Route::get('admin/admin/adminList', 'Admin\AdminController@index');     //管理员列表
    Route::get('admin/admin/adminAdd', 'Admin\AdminController@add');     //管理员添加页
    Route::post('admin/admin/insert', 'Admin\AdminController@insert');   //执行添加
    Route::get('admin/admin/adminChange/{id}', 'Admin\AdminController@edit');   //管理员修改页
    Route::post('admin/admin/update/{id}', 'Admin\AdminController@update');   //执行修改
    Route::get('admin/admin/delete/{id}', 'Admin\AdminController@delete');  //管理员删除
    Route::get('admin/admin/state/{id}', 'Admin\AdminController@state');  //管理员状态修改

    //合作商家
    Route::get('admin/partner/partnerList', 'Admin\PartnerController@index');     //列表页
    Route::get('admin/partner/partnerAdd', 'Admin\PartnerController@add');       //添加页面
    Route::post('admin/partner/insert', 'Admin\PartnerController@insert');       //执行添加
    Route::get('admin/partner/partnerChange/{id}', 'Admin\PartnerController@change');       //修改页面
    Route::post('admin/partner/update/{id}', 'Admin\PartnerController@update');       //执行修改
    Route::get('admin/partner/delete/{id}', 'Admin\PartnerController@delete');       //执行删除

    //用户类型
    Route::get('admin/user/userclass/userClassList', 'Admin\UserclassController@index');  //类型列表页
    Route::get('admin/user/userclass/userClassAdd', 'Admin\UserclassController@add');        //类型添加
    Route::post('admin/user/userclass/insert', 'Admin\UserclassController@insert');        //执行添加
    Route::get('admin/user/userclass/userClassChange/{id}', 'Admin\UserclassController@change');  //类型修改
    Route::post('admin/user/userclass/update/{id}', 'Admin\UserclassController@update');  //执行修改
    Route::get('admin/user/userlass/userClassDel/{id}', 'Admin\UserclassController@delete');  //执行删除

    //后台用户管理
    Route::get('admin/user/usermessage/userList', 'Admin\UserController@index');    //用户列表
    Route::get('admin/user/usermessage/userChange/{id}', 'Admin\UserController@change');    //用户列表
    Route::post('admin/user/usermessage/update/{id}', 'Admin\UserController@update'); //执行修改
    Route::get('admin/user/application/recharge', 'Admin\UserController@recharge'); //充值记录
    Route::post('admin/user/application/recharge', 'Admin\UserController@del'); //充值记录删除
    
    Route::get('admin/user/usermessage/state/{id}', 'Admin\UserController@state'); //状态修改
    Route::get('admin/user/usermessage/userDetail/{id}', 'Admin\UserController@detail'); //详情页
    Route::get('admin/user/usermessage/delete', 'Admin\UserController@delete'); //删除
    Route::get('admin/user/resetPass', 'Admin\UserController@reset'); //删除

    //代理商申请
    Route::get('admin/user/agency/agencyList', 'Admin\AgencyController@index');  //列表页
    Route::get('admin/user/agency/adopt/{id}', 'Admin\AgencyController@adpot');  //申请通过
    Route::post('admin/user/agency/reject/{id}', 'Admin\AgencyController@reject');  //申请驳回
    Route::get('admin/user/agency/cancel/{id}', 'Admin\AgencyController@cancel');  //取消代理商
    Route::get('admin/user/agency/show', 'Admin\AgencyController@show');  //查看原因

    //提现管理
    Route::get('admin/user/application/appList', 'Admin\ApplicationController@index');   //列表页
    Route::get('admin/user/application/adpot/{id}', 'Admin\ApplicationController@adpot');   //提现通过
    Route::post('admin/user/application/reject/{id}', 'Admin\ApplicationController@reject');   //提现驳回
    Route::get('admin/user/application/delete', 'Admin\ApplicationController@delete');   //提现删除
    Route::get('admin/user/application/dels', 'Admin\ApplicationController@dels');   //提现删除
    Route::get('admin/user/application/show', 'Admin\ApplicationController@show');   //查看原因

    //押金提现
    Route::get('admin/user/application/deposit','Admin\ApplicationController@deposit');

    //返利管理
    Route::get('admin/user/application/rebate', 'Admin\ApplicationController@rebate');   //列表
    Route::get('admin/user/application/rebateDetail/{id}', 'Admin\ApplicationController@detail'); //详情页面
    Route::get('admin/user/application/redel', 'Admin\ApplicationController@redel'); //删除

    //订单管理
    Route::get('admin/order/orderList', 'Admin\OrderController@orderList'); //全部订单
    Route::get('admin/order/orderMade/{num}', 'Admin\OrderController@orderIndex');     //待制作订单
    Route::get('admin/order/orderDeliver/{num}', 'Admin\OrderController@orderIndex'); //待发货
    Route::get('admin/order/orderDelivering/{num}', 'Admin\OrderController@orderIndex'); //已发货
    Route::get('admin/order/orderDetail/{id}', 'Admin\OrderController@detail');  //订单详情
    Route::get('admin/order/orderUpload/{id}', 'Admin\OrderController@upload');  //查看文件
    Route::get('admin/order/delete', 'Admin\OrderController@delete');  //订单删除
    Route::get('admin/order/lib', 'Admin\OrderController@lib');  //订单出库
    Route::post('admin/order/updatePrice', 'Admin\OrderController@updatePrice');  //修改运费
    Route::get('admin/order/succ', 'Admin\OrderController@succ');  //制作完成
    Route::get('admin/order/library', 'Admin\OrderController@library');   //批量出库页面
    Route::post('admin/order/batchLibrary', 'Admin\OrderController@batchLibrary');   //执行批量出库
    Route::get('admin/ordertestResponseDownload/{id}', 'Admin\OrderController@download');   //下载文件
    Route::get('admin/order/logistic/{id}', 'Admin\OrderController@logistic');  //出库页面

    Route::get('admin/order/dels', 'Admin\OrderController@dels');  //批量删除

    Route::post('admin/order/orderDetails', 'Admin\PrintController@details');  //批量打印
    // Route::get('admin/order/print/{id}', 'Admin\PrintController@detail');  //批量打印

    Route::get('admin/order/chart', 'Admin\OrderController@char'); //销量图
    Route::get('admin/order/num', 'Admin\OrderController@num'); //销量图数据

    //权限
    Route::match(['get','post'],'admin/admin/nodeAdd','Admin\AdminController@nodeAdd');   //添加节点
    Route::get('admin/admin/nodeUpdate/{id}','Admin\AdminController@nodeUpdate');   //修改节点
    Route::post('admin/admin/nodeEdit/{id}','Admin\AdminController@nodeEdit');   //执行修改节点
    Route::get('admin/admin/nodeDel','Admin\AdminController@nodeDel');   //删除节点
    Route::get('admin/admin/nodeList','Admin\AdminController@nodeList');   //节点列表
    Route::get('admin/admin/userGroup','Admin\AdminController@userGroup');//添加分组
    Route::post('admin/admin/groupAdd','Admin\AdminController@groupAdd');//执行添加分组
    Route::get('admin/admin/groups','Admin\AdminController@groups'); // 分组管理
    Route::get('admin/admin/show','Admin\AdminController@show'); // 分组管理
    Route::get('admin/admin/groupChange/{id}','Admin\AdminController@groupChange'); // 分组修改
    Route::post('admin/admin/groupEdit','Admin\AdminController@groupEdit'); // 执行修改
    Route::get('admin/admin/groupDel','Admin\AdminController@groupDel'); // 执行修改

    //评论
    Route::get('admin/critical/ciritical','Admin\CommentController@index');   //列表页
    Route::get('admin/critical/ciriticalDelete/{id}','Admin\CommentController@delete');   //删除
    Route::get('admin/critical/ciriticalAdpot/{id}','Admin\CommentController@adpot');   //通过
    Route::post('admin/critical/ciriticalReject/{id}','Admin\CommentController@reject');  //驳回
});
