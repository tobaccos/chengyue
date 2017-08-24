<?php

namespace App\Http\Controllers\Admin;

use App\Http\Models\ProAttr;
use App\Http\Models\ProCombination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class ProComController extends CommonController
{
    //分类列表
    //| GET|HEAD | admin/pro_com | index
    public function index()
    {
        $data = ProCombination::orderBy('id','desc')->paginate(10);
        return view('admin.product.procom.list')->with('data', $data);
    }

    //添加分类提交
    //| POST | admin/pro_com | .store
    public function store()
    {
        $input = Input::except('_token','s');
        $rules = [
            'name'=>'required|unique:pro_combination|max:30',
        ];

        $message = [
            'name.required'=>'请填写分组名称！',
            'name.unique' => '分组已存在！',
            'name.max' => '分组名称不能超过30个字符！',
        ];

        $validator = Validator::make($input,$rules,$message);
        if($validator->passes()){
            $input['clert'] = session('admin') ? session('admin') : 1;
            if(isset($input['attrOld'])){
                $input['conbination'] = '';
                foreach($input['attrOld'] as $v){
                    $input['conbination'] .= $v . '_';
                }
                $input['conbination'] = trim($input['conbination'], '_');
                unset($input['attrOld']);
            }
            $res = ProCombination::create($input);
            return $res ? redirect('admin/pro_com'): back()->with('errors','数据添加失败！');
        }else{
            return back()->withErrors($validator);
        }
    }

    //添加分类页面
    //| GET|HEAD  | admin/pro_com/create | .create
    public function create()
    {
        $attrArr = [];
        $res = ProAttr::select('id','name','state','status')->where('state',0)->get()->toArray();
        foreach($res as $v){
            if($v['status'] == 0)
                $v['name'] .= '(基本属性)';
            elseif($v['status'] == 1)
                $v['name'] .= '(多选属性)';
            elseif($v['status'] == 2)
                $v['name'] .= '(自定义属性)';
            $attrArr[] = $v;

        }//dd($attrArr);
        return view('admin.product.procom.change', compact('attrArr'));
    }

    //编辑分类页面
    //| GET|HEAD | admin/pro_com/{pro_com}/edit | .edit
    public function edit($id)
    {
        $attrArr = [];
        $data = ProCombination::find($id);
        $res = ProAttr::select('id','name','state','status')->where('state',0)->get()->toArray();
        foreach($res as $v){
            if($v['status'] == 0)
                $v['name'] .= '(基本属性)';
            elseif($v['status'] == 1)
                $v['name'] .= '(多选属性)';
            elseif($v['status'] == 2)
                $v['name'] .= '(自定义属性)';

            $v['select'] = in_array($v['id'], explode('_', $data['conbination']));
            $attrArr[] = $v;
        }
        return view('admin.product.procom.change',compact('data', 'attrArr'));
    }

    //编辑分类提交
    //| PUT|PATCH | admin/pro_com/{pro_com} | .update
    public function update($id)
    {
        $input = Input::except('_method','_token','s');
        $rules = [
            'name'=>'required|max:30|unique:pro_combination,name,'.$id,
        ];

        $message = [
            'name.required'=>'请填写分组名称！',
            'name.max' => '分组名称不能超过30个字符！',
            'name.unique' => '分组名称已存在！',
        ];

        $validator = Validator::make($input,$rules,$message);
        if($validator->passes()){
            $input['clert'] = session('admin') ? session('admin') : 1;
            if(isset($input['attrOld'])){
                $input['conbination'] = '';
                foreach($input['attrOld'] as $v){
                    $input['conbination'] .= $v . '_';
                }
                $input['conbination'] = trim($input['conbination'], '_');
                unset($input['attrOld']);
            }
            $res = ProCombination::where('id',$id)->update($input);
            return $res ? redirect('admin/pro_com'): back()->with('errors','分组信息更新失败！');
        }else{
            return back()->withErrors($validator);
        }
    }

    //显示分类信息
    //| GET|HEAD | admin/pro_com/{pro_com} | .show
    public function show($id)
    {
        $comData = ProCombination::find($id);
        $comArr = explode('_', $comData['conbination']);
        $attrArr = [];
        foreach($comArr as $v){
            $attrArr[] = ProAttr::select('id','name','state','status')->where('state',0)->where('id',$v)->get()->first()->toArray();
        }
        return view('admin.product.procom.show',compact('comData','attrArr'));
    }

    //删除分类
    //| DELETE    | admin/pro_com/{pro_com}        | .destroy
    public function destroy($cate_id)
    {
            $data = ProCombination::where('id',$cate_id)->first();
            //删除组下的属性
            /*$attrIds = explode('_', $data->conbination);
            foreach ($attrIds as $v){
                ProAttr::where('id', $v)->delete();
            }*/
            $res = $data->delete();
            return $res ? ['status' => 1, 'msg' => '分组删除成功！']: ['status' => 0, 'msg' => '分组删除失败！'];
    }

    //批量删除
    public function dels()
    {
        //DB::table('xx')->whereIn('primaryKey',[1,3,5])->update(['status'=>1]);
        $input = Input::get('delitems');//return ['state'=> 0, 'data'=>$input];
        foreach($input as $id){
            $data = ProCombination::where('id',$id)->first();
            //删除组下的属性
            /*$attrIds = explode('_', $data->conbination);
            foreach ($attrIds as $v){
                ProAttr::where('id', $v)->delete();
            }*/
            $res = $data->delete();
        }
        return ['state'=>'1', 'msg'=>'删除成功！'];//redirect('admin/product');
    }
}
