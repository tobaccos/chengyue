<?php
namespace App\Http\Controllers\Home;

use function foo\func;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use DB;
use Illuminate\Support\Facades\Input;
use Storage;

class ProductController extends Controller
{
    /*
     * 商品列表
     * 2017.4.26
     *
     */
    public function proList($id)
    {

        $where['state'] = 0;
        if($id != 0){
            $where['type_id'] = $id;
        }

        $fieldProduct = array('id','thumbing','name','min');
        $data = DB :: table('product')
            ->where($where)
            ->select($fieldProduct)
            ->get();
        $count = count($data);
        $para['count'] = $count;
        $para['type_id'] = $id;
//dd($data);
        //获取所有产品类别
        $whereType['state'] = 0;
        $whereType['status'] = 1;
        $proTypes = DB :: table('pro_type')
            ->where($whereType)
            ->select('id','name')
            ->get();
        $para['proType'] = $proTypes;

        //dump($para);die;
        return view(
            'home.product.proList',compact('data','para','id'));
    }


    /*
     * 商品列表排序
     * 2017.4.27
     */
    public function sort(Request $request)
    {
        $datas = $request -> except('_token');

        $where = array();
        $fieldProduct = array('id','thumbing','name','min','type_id');
        if(!isset($datas['type_id']) && isset($datas['cate_id']) && $datas['cate_id'] != 0){
            $where['type_id'] = $datas['cate_id'];
        }
        $where[] = ['state','=',0];

//        if(isset($datas['type_id'])){
//            $where[] = ['type_id','=',$datas['type_id']];
//        }

//        if(isset($datas['types'])){
//            $wherein= ['type_id',$datas['types']];
//        }

        if(isset($datas['minPrice'])){
        $where[] = ['min','>=',$datas['minPrice']];
        }

        if(isset($datas['maxPrice'])){
            $where[] = ['max','<=',$datas['maxPrice']];
        }

        if(isset($datas['sortType'])){
            $datas['sortType'] = $datas['sortType'];
        }else{
            $datas['sortType'] = 'id';
        }

        //return response() -> json($where);
        //判断是否模糊查询


        if(isset($datas['searchWrod'])){
            //模糊查询：判断是否排序
            if(isset($datas['type_id']) && $datas['type_id'][0] > 0){
                $data = DB :: table('product')
                    ->select($fieldProduct)
                    ->orderBy($datas['sortType'], 'desc')
                    ->where($where)
                    ->whereIn('type_id',$datas['type_id'])
                    ->whereRaw('instr(name, "'. $datas['searchWrod'] .'") > 0')
                    ->get();
            }else{
                $data = DB :: table('product')
                    ->select($fieldProduct)
                    ->where($where)
                    ->whereRaw('instr(name, "'. $datas['searchWrod'] .'") > 0')
                    ->orderBy($datas['sortType'], 'desc')
                    ->get();
            }

        }else{
            //没有进行，模糊查询情况下，判断是否排序
            if(isset($datas['type_id']) && $datas['type_id'][0] > 0){
                $data = DB :: table('product')
                    ->where($where)
                    ->select($fieldProduct)
                    ->whereIn('type_id',$datas['type_id'])
                    ->orderBy($datas['sortType'], 'desc')
                    ->get();
            }else{
                $data = DB :: table('product')
                    ->where($where)
                    ->orderBy($datas['sortType'], 'desc')
                    ->select($fieldProduct)
                    ->get();
            }

        }


        $str = '';
        foreach($data as $val){
            $str .='<li class="proItemList">
                        <a class="proImg" href="'.url("home/product/proDetail").'/'.$val->id.'/1">
                            <img src="'.PRO_IMG_PATH.$val->thumbing.'" alt="" />
                        </a>
                        <a class="proName" href="javascript:;">'.$val->name.'
                        </a>
                        <span class="proPrice">￥'.$val->min.'</span>
                    </li>';

        }
        return response() -> json($str);

    }

    /*
     * 活动列表
     * $show_time   时间排序
     * $collection  热度（收藏）
     */
    public function proActive(Request $request)
    {
        $where['state'] = 0;
        $data = DB :: table('activity')
            ->where($where)
            ->get();

        $count = count($data);
        $para['count'] = $count;
        //获取所有产品类别
        $whereType['state'] = 0;
//        $whereType['status'] = 1;
        $proTypes = DB :: table('pro_type')
            ->where($whereType)
            ->select('id','name')
            ->get();
        $para['proType'] = $proTypes;

        return view('home.product.proActive',['data'=> $data],['para'=>$para] );

    }

    /*
   * 今日推荐
   * post
   */
    public function toproActive(Request $request)
    {
        $datas = $request -> except('_token');

        $where = array();
        $fieldProduct = array('id','thumbing','name','min','type_id');
        $where[] = ['state','=',0];

        if(isset($datas['minPrice'])){
            $where[] = ['min','>=',$datas['minPrice']];
        }

        if(isset($datas['maxPrice'])){
            $where[] = ['max','<=',$datas['maxPrice']];
        }

        if(isset($datas['sortType'])){
            $datas['sortType'] = $datas['sortType'];
        }else{
            $datas['sortType'] = 'id';
        }

        if(isset($datas['searchWrod'])){
            //模糊查询：判断是否排序
            if(isset($datas['type_id']) && $datas['type_id'][0] > 0){
                $data = DB :: table('activity')
                    ->select($fieldProduct)
                    ->orderBy($datas['sortType'], 'desc')
                    ->where($where)
                    ->whereIn('type_id',$datas['type_id'])
                    ->whereRaw('instr(name, "'. filter_var($datas['searchWrod'],FILTER_SANITIZE_STRING) .'") > 0')
                    ->get();

            }else{
                $data = DB :: table('activity')
                    ->select($fieldProduct)
                    ->where($where)
                    ->whereRaw('instr(name, "'. filter_var($datas['searchWrod'],FILTER_SANITIZE_STRING) .'") > 0')
                    ->orderBy($datas['sortType'], 'desc')
                    ->get();
            }

        }else{
            //没有进行，模糊查询情况下，判断是否排序
            if(isset($datas['type_id']) && $datas['type_id'][0] > 0){
                $data = DB :: table('activity')
                    ->where($where)
                    ->select($fieldProduct)
                    ->whereIn('type_id',$datas['type_id'])
                    ->orderBy($datas['sortType'], 'desc')
                    ->get();
            }else{
                $data = DB :: table('activity')
                    ->where($where)
                    ->orderBy($datas['sortType'], 'desc')
                    ->select($fieldProduct)
                    ->get();
            }

        }
//dd($data);

        $str = '';
        foreach($data as $val){
            $str .='<li class="proItemList">
                        <a class="proImg" href="'.url("home/product/proDetail").'/'.$val->id.'/4">
                            <img src="'.PRO_IMG_PATH.$val->thumbing.'" alt="" />
                        </a>
                        <a class="proName" href="javascript:;">'.$val->name.'
                        </a>
                        <span class="proPrice">￥'.$val->min.'</span>
                    </li>';

        }
        return response() -> json($str);


    }

    /*
     * 今日推荐
     * $show_time   时间排序
     * $volume      销量排序
     * $type        分类筛选
     */
    public function recommend(Request $request)
    {
//$id = 1;
        $where['state'] = 0;
        $data = DB :: table('recommend')
            ->where($where)
            ->get();

        $count = count($data);
        $para['count'] = $count;

        //获取所有产品类别
        $whereType['state'] = 0;
        $proTypes = DB :: table('pro_type')
            ->where($whereType)
            ->select('id','name')
            ->get();
        $para['proType'] = $proTypes;

        return view('home.product.recommend',['data'=> $data],['para'=>$para]);

    }

    /*
     * 今日推荐
     * post
     */
    public function torecommend(Request $request)
    {
        $datas = $request -> except('_token');

        $where = array();

        $where[] = ['state','=',0];

        if(isset($datas['minPrice'])){
            $where[] = ['min','>=',$datas['minPrice']];
        }

        if(isset($datas['maxPrice'])){
            $where[] = ['max','<=',$datas['maxPrice']];
        }

        if(isset($datas['sortType'])){
            $datas['sortType'] = $datas['sortType'];
        }else{
            $datas['sortType'] = 'id';
        }

        //return response() -> json($where);
        //判断是否模糊查询


        if(isset($datas['searchWrod'])){
            //模糊查询：判断是否排序
            if(isset($datas['type_id']) && $datas['type_id'][0] > 0){
                $data = DB :: table('recommend')
                    ->orderBy($datas['sortType'], 'desc')
                    ->where($where)
                    ->whereIn('type_id',$datas['type_id'])
                    ->whereRaw('instr(name, "'. filter_var($datas['searchWrod'],FILTER_SANITIZE_STRING) .'") > 0')
                    ->get();

            }else{
                $data = DB :: table('recommend')
                    ->where($where)
                    ->whereRaw('instr(name, "'. filter_var($datas['searchWrod'],FILTER_SANITIZE_STRING) .'") > 0')
                    ->orderBy($datas['sortType'], 'desc')
                    ->get();
            }

        }else{
            //没有进行，模糊查询情况下，判断是否排序
            if(isset($datas['type_id']) && $datas['type_id'][0] > 0){
                $data = DB :: table('recommend')
                    ->where($where)
                    ->whereIn('type_id',$datas['type_id'])
                    ->orderBy($datas['sortType'], 'desc')
                    ->get();
            }else{
                $data = DB :: table('recommend')
                    ->where($where)
                    ->orderBy($datas['sortType'], 'desc')
                    ->get();
            }

        }
//dd($data);

        $str = '';
        foreach($data as $val){
            $str .='<li class="proItemList">
                        <a class="proImg" href="'.url("home/product/proDetail").'/'.$val->id.'/2">
                            <img src="'.PRO_IMG_PATH.$val->thumbing.'" alt="" />
                        </a>
                        <a class="proName" href="javascript:;">'.$val->name.'
                        </a>
                        <span class="proPrice">￥'.$val->min.'</span>
                    </li>';

        }
        return response() -> json($str);


    }



    /*
     * 限时抢购
     * $show_time   时间排序
     * $volume      销量排序
     * $type        分类筛选
     */
    public function timeLimit(Request $request)
    {
        $where['state'] = 0;

        $fieldProduct = array('id','pic','name','min');
        $data = DB :: table('pre_buy')
            ->where($where)
//          ->select($fieldProduct)
            ->get();
        //过滤超过时间的商品
        foreach ($data as $key => $value){
            $end_time = $value->end_time;
            if($end_time < time() || $value->show_time > time()){
                unset($data[$key]);
            }
        }

        $count = count($data);
        $para['count'] = $count;
//        $para['type_id'] = $id;

        //获取所有产品类别
        $whereType['state'] = 0;
        $proTypes = DB :: table('pro_type')
            ->where($whereType)
            ->select('id','name')
            ->get();
        $para['proType'] = $proTypes;
//        var_dump($para);die;
//        dd($data);

        return view(
            'home.product.timeLimit',
            ['data'=> $data],
            ['para'=>$para]
        );



    }


    /*
     * 限时搜索
     */
    public function totimeLimit(Request $request)
    {
        $datas = $request -> except('_token');

        $where = array();
        $fieldProduct = array('id','thumbing','name','min','type_id');
        $where[] = ['state','=',0];



        if(isset($datas['minPrice'])){
            $where[] = ['min','>=',$datas['minPrice']];
        }

        if(isset($datas['maxPrice'])){
            $where[] = ['max','<=',$datas['maxPrice']];
        }

        if(isset($datas['sortType'])){
            $datas['sortType'] = $datas['sortType'];
        }else{
            $datas['sortType'] = 'id';
        }

        //return response() -> json($where);
        //判断是否模糊查询


        if(isset($datas['searchWrod'])){
            //模糊查询：判断是否排序
            if(isset($datas['type_id']) && $datas['type_id'][0] > 0){
                $data = DB :: table('pre_buy')
//                    ->select($fieldProduct)
                    ->orderBy($datas['sortType'], 'desc')
                    ->where($where)
                    ->whereIn('type_id',$datas['type_id'])
                    ->whereRaw('instr(name, "'. filter_var($datas['searchWrod'],FILTER_SANITIZE_STRING) .'") > 0')
                    ->get();

            }else{
                $data = DB :: table('pre_buy')
//                    ->select($fieldProduct)
                    ->where($where)
                    ->whereRaw('instr(name, "'. filter_var($datas['searchWrod'],FILTER_SANITIZE_STRING) .'") > 0')
                    ->orderBy($datas['sortType'], 'desc')
                    ->get();
            }

        }else{
            //没有进行，模糊查询情况下，判断是否排序
            if(isset($datas['type_id']) && $datas['type_id'][0] > 0){
                $data = DB :: table('pre_buy')
                    ->where($where)
//                    ->select($fieldProduct)
                    ->whereIn('type_id',$datas['type_id'])
                    ->orderBy($datas['sortType'], 'desc')
                    ->get();
            }else{
                $data = DB :: table('pre_buy')
                    ->where($where)
                    ->orderBy($datas['sortType'], 'desc')
//                    ->select($fieldProduct)
                    ->get();
            }

        }
//dd($data);
        foreach ($data as $key => $value){
            $end_time = $value->end_time;
            if($end_time < time() || $value->show_time > time()){
                unset($data[$key]);
            }
        }
//        dd($data);
        return response() -> json($data);

    }

    /*
     * 产品详情
     */
    public function detail($id,$number)
    {

        switch ($number){
            case 1:
                //产品
                $table = 'product';
                $back_url = url('home/product/proList/0');
            break;
            case 2:
                //今日推荐产品
                $table = 'recommend';
                $back_url = url('home/product/recommend');
            break;
            case 3:
                //限时抢购产品
                $table = 'pre_buy';
                $back_url = url('home/product/timeLimit');
            break;
            case 4:
                //活动产品
                $table = 'activity';
                $back_url = url('home/product/proActive');
            break;
        }

        $id = (int)$id;
        $userId = Auth::id();//用户id
        $wherePro['id'] = $id;
        $wherePro['state'] = 0;

        //查询产品基本信息
        $dataPro = DB::table($table)
            ->where($wherePro)
            ->get();

        foreach($dataPro as $value){
            $dataPro = $value;
        }

        if(isset($dataPro->con_attr))
            $infoAll = json_decode($dataPro->con_attr);
        else
            $infoAll = json_decode($dataPro->com_attr);

        //处理多张图片
        $images = explode('|',trim($dataPro->pic,'|'));
        $dataPro->pic = $images;

        $data['dataPro'] = $dataPro;
        //查看商品属性组合
//        $whereProAttr['id'] = $dataPro->com_id;
//        $dataProAttr = DB::table('pro_combination')
//            ->where($whereProAttr)
//            ->get();
        foreach($infoAll as $key=>$value){
            foreach($value as $k=>$val){
                if(isset($val->name)){
                    $data['attrName'][$k] = $val->name;
                    $data['attrType'][$k] = $val->type;
                }
            }
        }

        //处理属性组合字符串
        $price = array();
        foreach($infoAll as $key=>$value){
            $price[] = $value->price;
            foreach($value as $k=>$v){
                if(isset($v->value)) {
                    if(isset($data['attrArr'][$k])) {
                        if (is_object($v->value)) {
                            if (!in_array($v->value->name, $data['attrArr'][$k])) {
                                $data['attrArr'][$k][] = $v->value->name;
                                $data['attr_price'][$v->value->name] = $v->value->value;
                            }
                        } else {
                            if (!in_array($v->value, $data['attrArr'][$k])) {
                                $data['attrArr'][$k][] = $v->value;

                            }
                        }
                    }else{
                        if (is_object($v->value)) {
                            $data['attrArr'][$k][] = $v->value->name;
                            $data['attr_price'][$v->value->name] = $v->value->value;
                        } else {
                            $data['attrArr'][$k][] = $v->value;

                        }
                    }

                }
            }

            //$price = $v->price;
        }
        $attrs = array();
        foreach($infoAll as $value){
            foreach($value as $k=>$v){
                if(is_object($v)){
                    if(!is_object($v->value)){
                        //var_dump($v->value);die;
                        $attrs1[$k] = $v->value;
                    }
                }else{
                    $attrs1[$k] = $v;
                }
            }
            $attrs[] = $attrs1;
        }

        //查看是否收藏此产品
        $where['user_id'] = $userId;
        $where['pro_id'] = $id;
        $field = 'id';
        $resCollect = DB::table('user_collection')
            ->where($where)
            ->select($field)
            ->get();
        if(isset($resCollect[0]->id)){
            $data['collect'] = true;
        }else {
            $data['collect'] = false;
        }

        //评论部分
        $whereCom['comment.pro_id'] = $id;
        $whereCom['comment.state'] = 1;
        $comments = DB :: table('comment')
            ->where($whereCom)
            ->join('users','users.id','=','comment.user_id')
            ->join('user_info','user_info.user_id','=','comment.user_id')
            ->select('comment.image','comment.image','comment.content','users.name','user_info.pic')

            ->get();
        $data['comment'] = $comments;//商品评论
        $data['attrs'] = $attrs;//所有组合数组D（不包括多选）
        $data['max'] = max($price);//商品最大价格（不包括多选价格）
        $data['min'] = min($price);//商品最小价格（不包括多选价格）
        $data['typeNumber'] = $number;//用于区分产品来自哪个表
        //$data['attrArr'] = $attrArr;//去重复属性值后的组合数组
        //$data['attr_price'] = $attr_price;//多选属性对应的价格
        $data['attrsjson'] = json_encode($attrs);
        return view('home/product/proDetail',['data'=> $data, 'userId'=>$userId, 'backUrl'=>$back_url]);
    }

    /*
     * 详情页文件上传
     */
    public function upload(Request $request,$pid){

        $datas = $request -> except('_token');

        $userId = Auth::id();//用户id
        if ($userId == "")
        {
            $backData['state'] = "404";
            $backData['msg'] = "未登录，请先登录";
            $backData['url'] = url("/login");
            //$this->ajaxReturn($backData, "json");
            return response() -> json($backData);
        }

        $uid = $userId; // 用户id
        //$pid = I('pid');	// 产品id

        $file = $request->file('file');

        if ($request->isMethod('post')) {
            $file = $request->file('file');
            // 获取文件相关信息
            $originalName = $file->getClientOriginalName(); // 文件原名

            // 文件是否上传成功
            if ($file->isValid()) {

                $ext = $file->getClientOriginalExtension();     // 扩展名

                $realPath = $file->getRealPath();   //临时文件的绝对路径

                //$type = $file->getClientMimeType();     // image/jpeg

                // 上传文件
                //$filename = date('Y-m-d-H-i-s') . '-' . uniqid() . '.' . $ext;
                $filename = md5($pid.$userId.date('ymdhis')). '.' . $ext;

                //return response() -> json(file_get_contents($realPath));
                // 使用我们新建的uploads本地存储空间（目录）
                $bool = Storage::disk('temp')->put($filename, file_get_contents($realPath));

            }

        }


        if(!$bool)
        {
            // 上传失败
            $backData['state'] = '403';
            $backData['msg'] = "上传失败！";
            return response() -> json($backData);
        }else{
            // 上传成功
            $backData['state'] = '200';
            $backData['msg'] = "文件上传成功！";
            $backData['filename'] = $filename;
            return response() -> json($backData);
        }

//        $savepath = $rootPath.$info[0]['savepath'];
//        $savepath = substr($savepath, 1);
//        $data[$uid][$pid]['imgPath'] = $savepath.$info[0]['savename'];
//        //S('userPhoto',$data);
//

    }

    /*
     * 删除收藏产品
     */
    public function collect_del(Request $request)
    {
        $pro_id = $request -> get('id');
        $user_id = Auth::id();
//        $where['pro_id'] = $pro_id;

        $res = DB::table('user_collection')
                    ->where([
                        ['id', $pro_id],
                        ['user_id', $user_id],
                    ])
                    ->delete();
        return $res ? "200" : "404";

    }

    /*
     * 产品收藏
     */
    public function collect(Request $request){
        $datas = $request -> except('_token');

        $userId = Auth::id();//用户id
        //判断是否登陆
        if($userId == '' && $userId == false ){
            return response() -> json('请登录');
//            die;
        }
        $where['user_id'] = $userId;
        $where['pro_id'] = $datas['proId'];
        $where['table_type'] = $datas['typeNumber'];
        $field = 'id';
        $res = DB::table('user_collection')
            ->where($where)
            ->select($field)
            ->get();
        if(isset($res[0]->id)){
            //如果不为空，说明已经收藏此商品，删除收藏
            $res1 = DB::table('user_collection')
                ->where($where)
                ->delete();
            DB::table(get_pro_table($datas['typeNumber']))->where('id',$datas['proId'])->decrement('collection',1);
            return 1;
        }else{
            //如果为空，说明没有收藏此商品，加入收藏
            $data1['user_id'] = $userId;
            $data1['pro_id']  = $datas['proId'];
            $data1['created_at'] = time();
            $data1['table_type'] = $datas['typeNumber'] ;//return $data1;
            DB::table(get_pro_table($datas['typeNumber']))->where('id',$datas['proId'])->increment('collection',1);
            $res1 = DB::table('user_collection')->insert($data1);
            return 0;
        }

        return response() -> json($res1);
    }
    /*
     *  订单详情
     */
    public function proinfo($order_sn)
    {
//     var_dump($order_sn);die;
//        $input = ['id'=>1];
        $userId = Auth::id();
        $table_type = DB::table('orders')
            ->where('order_sn',$order_sn)
            ->first();

        switch ($table_type->table_type)
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

        $orders = DB::table('orders')
            ->join($table,'orders.pro_id','=',$table.'.id')
            ->join('pro_type',$table.'.type_id','=','pro_type.id')
            ->select($table.'.thumbing','orders.addtime','orders.order_status','pro_type.name as tname',$table.'.name as pname','orders.pro_attr','orders.pro_price','orders.pay_amount')
            ->where([
                ['orders.user_id',$userId],
                ['orders.order_sn',$order_sn],
            ])
            ->first();
        //处理json
        $orders ->　pro_attr = json_decode($orders -> pro_attr);
        $address = DB::table('user_address')
            ->Join('orderinfo','orderinfo.address','=','user_address.id')
            ->where([
                ['orderinfo.order_sn',$order_sn]
            ])
            ->first();
//var_dump($orders);die;
        return view ('home.member.proinfo',['data'=>$orders,'address'=>$address]);

    }


    /*
     * 商品评价页
     */
    public function reviews(Request $request)
    {

      $input = $request->only('order_sn');

//        $input = ['id'=>25];
        $userId = Auth::id();
//        var_dump($userId);die;
        $orders = DB::table('orders')
            ->where([
                ['orders.user_id',$userId],
                ['orders.order_sn',$input['order_sn']],
                ['orders.order_status',4] // 4为已签收
            ])
            ->first();

        if ($orders->table_type == 1) {
            $table = 'product';
        } elseif ($orders->table_type == 2){
            $table = 'recommend';
        }elseif($orders->table_type == 3) {
            $table = 'pre_buy';
        }elseif($orders->table_type == 4){
            $table = 'activity';
        }

        $type_name = DB::table($table)
            ->join('pro_type','pro_type.id','=',$table.'.type_id')
            ->select('pro_type.name as type_name',$table.'.*')
            ->first();
        $orders->type_name = $type_name->type_name;
        $orders->name = $type_name->name;

//var_dump($orders);die;

        return view('home.member.reviews',['data'=>$orders]);
    }

    /*
     * 商品评价
     */
    public function proReviews(Request $request)
    {

//        dd($request->all());
        $userId = Auth::id();
        $input = $request->except('_token','s','myFile');
        $file = $request->file('myFile');

        if($file && $file->isValid()){
            $originalName = $file->getClientOriginalName();     // 文件原名 3.jpg
            $extension = $file->getClientOriginalExtension();   // 扩展名 jpg
            $allow_extensions = ['jpg','png','jpeg',];
            if($originalName && !in_array($extension,$allow_extensions))
            {
                return back() ->with(['info','上传格式错误']);
            }
            $type = $file->getClientMimeType();     // image/jpeg
            $newName = date('YmdHis').mt_rand(1000,9999).".".$extension;
            $path = $file->move(base_path()."/public/uploads/comment",$newName);
            if(!$path){
                return back() ->with(['info','上传失败']);
            }
            $filepath = 'uploads/'.$newName;
//            return $filepath;
            $input['image'] = $newName  ;
        }
        if($input['content'] == "" && isset($input['image']) == "")
        {
            return back() ->with(['info'=> '您还没有评论']);
        }
        $input['user_id'] = $userId;
        $res1 = DB::table('orders')
            ->where([
                ['id',$input['order_id']],
                ['user_id',$input['user_id']]
            ])
            ->update(['order_status'=> 5]);
        unset($input['order_sn']);

        $res = DB::table('comment')->insert($input);


        return $res ? redirect('/home/member/reviewssuccess') : back() ->with(['info'=>'评价失败']);
    }

    /*
     * 我的收藏
     */

    public function myfavorite(Request $request)
    {
        $userId = Auth::id();
        //收藏
        $table_type = DB::table('user_collection')->where('user_id',$userId)->get();
        if(count($table_type) < 1){
            $res = [];
        }
        foreach ($table_type as $k => $v){

            if ($v->table_type == 1) {
                $table = 'product';
            } elseif ($v->table_type == 2){
                $table = 'recommend';
            }elseif($v->table_type == 3) {
                $table = 'pre_buy';
            }elseif($v->table_type == 4){
                $table = 'activity';
            }
            $collection =  DB::table($table)
                ->join('user_collection',$table.'.id','=','user_collection.pro_id')
                ->where([
                    ['user_collection.user_id',$userId],
                    [$table.'.id',$v->pro_id]
                ])
//			->select('user_collection.id','product.*')
                ->first();

            if($collection){
                $res[] = $collection;
            }

        }
        foreach ($res as $key => $value)
        {
            $type_name = DB::table('pro_type')->where('id',$value->type_id)->select('name')->first();
            $res[$key]->type_name = $type_name->name;
        }

//       dd($res);
//        $collection['count'] = count($collection);

        return view('home.member.myfavorite',['data'=>$res]);
    }

    //分类
    public function sorts(){
        $where['state'] = 0;
        $fieldProduct = array('id','thumbing','name','min');
        $data = DB :: table('product')
            ->select($fieldProduct)
            ->get();
        $count = count($data);
        $para['count'] = $count;
//dd($data);
        //获取所有产品类别
        $whereType['state'] = 0;
        $whereType['status'] = 1;
        $proTypes = DB :: table('pro_type')
            ->where($whereType)
            ->select('id','name')
            ->get();
        $para['proType'] = $proTypes;
        $para['type_id'] = 0;
        //dump($para);die;
        return view(
            'home.product.proList',
            ['data'=> $data],
            ['para'=>$para]
        );
    }


}
