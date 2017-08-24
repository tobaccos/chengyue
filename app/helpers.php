<?php
/*
*	公共方法定义
*/


/**
 * 上传单个图片
 * @param $file     单个图片实例
 * @param $pathInfo 图片上传目录
 * @param $newImageName 图片名称
 * @return bool false 上传失败
 */
function uploadOne(\Illuminate\Http\UploadedFile $file, $pathInfo = 'uploads', $newImageName = ''){
    //dd($file);
    $pathInfo = trim($pathInfo, '/');
    if($file->isValid()){
        //检验一下上传的文件是否有效.
        $clientName = $file -> getClientOriginalName();
        $tmpName = $file ->getFileName(); // 缓存在tmp文件夹中的文件名 例如 php8933.tmp 这种类型的.
        $realPath = $file -> getRealPath();    //这个表示的是缓存在tmp文件夹下的文件的绝对路径
        $extension = $file -> getClientOriginalExtension(); //上传文件的后缀.
        $mimeTye = $file -> getMimeType();//得到的结果是 image/jpeg.
        $newName = empty($newImageName) ? substr(md5(date('ymdhis').$clientName),0 ,30): $newImageName;
        $newName = $newName.".".$extension;
        $Info = $file -> move($pathInfo, $newName);

        return ['name'=>$newName,'info'=>$Info];
    }
    return false;
}

function uploadify( $pathInfo = 'uploads', $newImageName = '')
{
    $file = \Illuminate\Support\Facades\Input::file('Filedata');//return dd($file);
    $pathInfo = trim($pathInfo, '/');
    if($file -> isValid()){
        //检验一下上传的文件是否有效.
        $clientName = $file -> getClientOriginalName();
        $tmpName = $file ->getFileName(); // 缓存在tmp文件夹中的文件名 例如 php8933.tmp 这种类型的.
        $realPath = $file -> getRealPath();    //这个表示的是缓存在tmp文件夹下的文件的绝对路径
        $extension = $file -> getClientOriginalExtension(); //上传文件的后缀.
        $mimeTye = $file -> getMimeType();//得到的结果是 image/jpeg.
        $newName = empty($newImageName) ? substr(md5(date('ymdhis').$clientName),0 ,30): $newImageName;
        $newName = $newName.".".$extension;
        $Info = $file -> move($pathInfo, $newName);
        $filepath = '/' . $pathInfo . '/' . $newName;
        return ['state'=>'1','url'=>$filepath,'name'=>$newName,'info'=>$Info];
    }
}

/**
 * 根据id获取管理员名称
 * @param $id   管理员id
 * @return mixed    管理员名称
 */
function getAdminById($id){
    return \Illuminate\Support\Facades\DB::table('admin')->where('id', $id)->pluck('name')->first();
}

/**
 * 根据id获取产品分类名称
 * @param $id
 * @return mixed
 */
function getCateNameById($id){
    return \Illuminate\Support\Facades\DB::table('pro_type')->where('id', $id)->pluck('name')->first();
}

/**
 * 根据id获取属性名
 * @param $com_id
 * @return mixed
 */
function getComNameById($com_id){
    return \Illuminate\Support\Facades\DB::table('pro_attr')->where('id', $com_id)->pluck('name')->first();
}

function moveFile($oldFile, $newFile){
    \Illuminate\Support\Facades\Storage::move($oldFile, $newFile);
}

/**
 * @param $fileName 文件名
 * @return bool     是否删除成功
 */
function delFile($fileName){
    if(is_dir($fileName) || !file_exists($fileName))
        return 3;//文件不存在
    return unlink($fileName);
}

/**
 * 请求数据库
 * @param [type] $db       [表名]
 * @param string $fieldArr [字段]
 * @param string $where    [条件]
 */
function RequestDB($db, $fieldArr = '', $where = '') {
    $res = DB :: table($db)
        ->select($fieldArr)
        ->where($where)
        ->get();
    return $res;
}


/**
 * [getOrderId 生成订单号 唯一值]
 * Typecho Blog Platform
 * @copyright [copyright]
 * @license   [license]
 * @param     [type]      $id    [获取用户id]
 * @return    [type]             [返回订单号]
 */
function getOrderId($id) {

    $str = substr(str_replace(" ", "", str_replace(".", "", microtime())),-18).$id  ;
    return $str;
}


/**
 * 根据产品属性对象获取产品利率和价格
 * @param $value    前台压入的属性对象
 * @return array
 */
function getProPrice($value){
    //获取产品数据
    $table = '';
    $price = 0;//产品属性价格（含多选属性）
    $rate = '';//利率
    if($value->typeNumber == 1)
        $table = 'product';
    elseif($value->typeNumber == 2)
        $table = 'recommend';
    elseif($value->typeNumber == 3)
        $table = 'pre_buy';
    elseif($value->typeNumber == 4)
        $table = 'activity';

    if($value->typeNumber == 1)
        $info = DB::table($table)->where('id',$value->proId)->select('con_attr','thumbing')->first();
    else
        $info = DB::table($table)->where('id',$value->proId)->select('com_attr','thumbing')->first();

    if(empty($info))return null;

    if($value->typeNumber == 1)
        $attrArr = json_decode($info->con_attr, true);//产品属性组
    else
        $attrArr = json_decode($info->com_attr, true);//产品属性组
    //获取多选价格
    if(isset($value->selfAttrObject)){
        foreach($value->selfAttrObject as $v){
            if(isset($v)){
                $checkArr = explode('_', $v);
                foreach($attrArr as $attr){
                    if($attr[$checkArr[0]]['value']['name'] == $checkArr[1]){
                        $price += $attr[$checkArr[0]]['value']['value'] + 0;
                        break;
                    }
                }
            }
        }
    }
    //获取普通属性组价格
    if(isset($value->attrNameVal)){
        foreach($attrArr as $key => $attr){
            $isAccord = false;//是否符合条件
            $custom = [];//自定义数据
            foreach($value->attrNameVal as $k => $v){
                if($attr[$k]['type'] == '0' && $attr[$k]['value'] == $v)
                    $isAccord = true;
                elseif($attr[$k]['type'] == '2'){
                    $custom[] = $v;
                }else{
                    $isAccord = false;
                    break;
                }
            }

            if($isAccord){
                $rate = $attr['rate'];
                $price += $attr['price'] + 0;
                if(!empty($custom)){
                    foreach($custom as $v){
                        $price *= $v + 0;
                    }
                }
                break;
            }
        }
    }
    return ['rate'=>$rate, 'price'=>$price, 'thumbing'=>$info->thumbing];
}

function get_client_ip()
{
    if ($_SERVER['REMOTE_ADDR']) {
        $cip = $_SERVER['REMOTE_ADDR'];
    } elseif (getenv('REMOTE_ADDR')) {
        $cip = getenv('REMOTE_ADDR');
    } elseif (getenv('HTTP_CLIENT_IP')) {
        $cip = getenv('HTTP_CLIENT_IP');
    } else {
        $cip = 'unknown';
    }
    return $cip;
}

/**
 * 获取产品图片第一张图片
 * @param $table
 * @param $pro_id
 * @param bool $path    是否包含路径
 */
function get_pro_pic_first($table, $pro_id, $path = true)
{
    $info = DB::table($table)->select('pic')->where('id',$pro_id)->get()->first();//var_dump($pro_id);die;
    $picStr = trim($info->pic, '|');
    $picArr = explode('|', $picStr);
    //
    return $path ? PRO_IMG_PATH.$picArr[0] : $picArr[0];
}

/**
 * 通过别名获取广告
 * @param $pos_alias
 */
function get_ad($pos_alias){
    $ad = App\Http\Models\Ad::get()->toArray();
    $AdPosition =App\Http\Models\AdPosition::get()->toArray();
//    dd($AdPosition);
//    $res = DB::table('ad')
//        ->join('ad_position','ad.position','=','ad_position.id')
//        ->select('ad_position.alias')
//        ->get()
//        ->toArray();
//    foreach ($res as $key => $value){
//        $alias[] = $value->alias;
//
//        if(in_array($pos_alias,$alias)){
////            return "该广告位是空的！";
//            var_dump("a");
//        }
//    }

    $pos = \App\Http\Models\AdPosition::select('id','alias')->where('alias','like',$pos_alias.'%')->first();

//    $pos = \App\Http\Models\AdPosition::select('id','alias')->where('alias',$pos_alias)->first();

    if(empty($pos))
        return '广告位错误';
    $pos = $pos->toArray();
    $adArr = \App\Http\Models\Ad::orderBy('id','desc')->where([['position',$pos['id']],['state',1]])->get();
    if(empty($adArr))
        return '广告错误';
    $adArr = $adArr->toArray();
    //取最新
    $adDiv = '';
    if($adArr[0]['type'] == 0){//图片类型
        if(empty($adArr[0]['url'])){
            $adDiv = '<img src="'. AD_IMG_PATH.$adArr[0]['pic'] .'">';
        }else{
            $adDiv = '<a href="'. $adArr[0]['url'] .'"><img src="'. AD_IMG_PATH.$adArr[0]['pic'] .'"></a>';
        }
    }
    return $adDiv;
}

/**
 * 根据类型获取相应的产品表
 * @param $table_type
 * @return mixed
 */
function get_pro_table($table_type){
    if($table_type == 1)
        $table = 'product';
    elseif($table_type == 2)
        $table = 'recommend';
    elseif($table_type == 3)
        $table = 'pre_buy';
    elseif($table_type == 4)
        $table = 'activity';
    return $table;
}

