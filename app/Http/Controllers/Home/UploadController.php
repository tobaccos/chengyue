<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use Auth;

class UploadController extends Controller
{
    //上传页面
    public function index($id,$number)
    {
      $uid = Auth::id();
      $picName1 = session($uid.'_'.$id.'_'.$number.'_'.'picName1');
      $picName2 = session($uid.'_'.$id.'_'.$number.'_'.'picName2');
      $data = explode('&&', $picName1);
      $date = explode('&&', $picName2);
      if(!empty($data['0']) && !empty($date['0']))
      {
        return view('home/product/uploadRequire',['id' => $id,'number' => $number,'data' => $data,'date' => $date]);
      }elseif(!empty($data['0']))
      {
        return view('home/product/uploadRequire',['id' => $id,'number' => $number,'data' => $data]);
      }elseif(!empty($date['0']))
      {
        return view('home/product/uploadRequire',['id' => $id,'number' => $number,'date' => $date]);
      }
    	return view('home/product/uploadRequire',['id' => $id,'number' => $number]);
    }

    //上传
    public function upload(Request $request)
	  {
	  	//判断图片是否存在
      $uid = Auth::id();
      $data = $request -> except('_token');
      $id = $data['id'];
      $number = $data['number'];
      // dd($data);
      //判断格式
      $type1 = $_FILES['pic1']['type'];
      $type2 = $_FILES['pic2']['type'];
      if($type1 != 'image/jpeg' &&  $type1 != 'image/bmp' && $type1 != 'image/jpg' && $type1 != 'image/png' && $type2 != 'image/jpeg' &&  $type2 != 'image/bmp' && $type2 != 'image/jpg' && $type2 != 'image/png')
      {
          // 格式失败
          return '405';
      }
      //判断是否上传了图片
      if(!isset($data['pic1']) && !isset($data['pic2']))
      {
        return '405'; 
      }
      //是否填写了需求
      if(!isset($data['require1']) && !isset($data['require2']))
      {
        return '406'; 
      }
      //第一张图
      if(isset($data['pic1']))
      {
        //获取图片扩展名
        $extension = $data['pic1'] -> getClientOriginalExtension();

        //拼接图片名称
        $fileName = str_random(10).'.'.$extension;
        $dir = 'uploads/temp/';

        //判断目录是否存在
        if(!file_exists($dir))
        {
            mkdir($dir,0777,true);
        }

        //移动
        $move = $data['pic1'] -> move($dir,$fileName);

        //判断是否移动成功
        if(!$move)
        {
           return '404'; 
        }
        if(!isset($data['require1']))
        {
          return '403';
        }
        //存入session
        $request -> session() -> put($uid.'_'.$id.'_'.$number.'_'.'picName1',$fileName.'&&'.$data['require1']);
      }

      //第二张图
      if(isset($data['pic2']))
      {
        //获取图片扩展名
        $extension = $data['pic2'] -> getClientOriginalExtension();

        //拼接图片名称
        $fileName = str_random(10).'.'.$extension;
        $dir = 'uploads/temp/';

        //判断目录是否存在
        if(!file_exists($dir))
        {
            mkdir($dir,0777,true);
        }

        //移动
        $move = $data['pic2'] -> move($dir,$fileName);

        //判断是否移动成功
        if(!$move)
        {
           return '404'; 
        }
        if(!isset($data['require2']))
        {
          return '403';
        }
        //存入session
        $request -> session() -> put($uid.'_'.$id.'_'.$number.'_'.'picName2',$fileName.'&&'.$data['require2']);
      }
      return '200';
    }
}

