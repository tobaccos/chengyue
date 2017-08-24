<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Session;
use DB;

class CommonController extends Controller
{
//     //目的是查询管理员权限
     public function __construct()
     {
         $this->middleware(function ($request, $next){
             $id = Session::get('admin');
             //查询所在分组
             $group = DB::table('admin') ->select('group_id') -> where('id',$id) -> first();
 //            var_dump($group);die;
             //查询管理员所在分组的权限
             $group = DB::table('group') ->select('roles') -> where('id',$group->group_id) -> first();
             //处理数据
             $roles = explode(',',$group->roles);
             $rules = array();
             foreach ($roles as $v) {
                 $rules[] = DB::table('rules') -> select('name','url','father_id') -> where('id',$v) -> first();
             }

             //处理路径
             foreach ($rules as $k=>$rule) {
                 //去除空数组
                 if (!$rule) {
                     unset($rules[$k]);
                 }
             }
//             var_dump($rules);die;.
             Session::put('ruleIndex',$rules);
             return $next($request);
         });
     }

}
