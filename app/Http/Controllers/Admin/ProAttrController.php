<?php

namespace App\Http\Controllers\Admin;

use App\Http\Models\Activity;
use App\Http\Models\Category;
use App\Http\Models\PreBuy;
use App\Http\Models\ProAttr;
use App\Http\Models\ProCombination;
use App\Http\Models\Product;
use App\Http\Models\Recommend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class ProAttrController extends CommonController
{
    //属性列表
    //| GET|HEAD | admin/pro_attr | .index
    public function index()
    {
        $data = ProAttr::orderBy('id','desc')->paginate(10);
        return view('admin.product.proattr.attrList')->with('data', $data);
    }

    //添加属性提交
    //| POST | admin/pro_attr | .store
    public function store()
    {
        $input = Input::except('_token','s');
        $rules = [
            'name'=>'required|unique:pro_attr|max:24',
            'status'=>'required|between:0,2',
            'state'=>'required|between:0,1',
        ];

        $message = [
            'name.required'=>'请填写属性名称！',
            'name.unique' => '属性名已存在！',
            'name.max' => '属性名不能超过24个字符！',
            'status.required'=>'请选择属性类型！',
            'status.between'=>'类型选择错误！',
            'state.required'=>'请选择属性状态！',
            'state.between'=>'状态选择错误！',
        ];

        $validator = Validator::make($input,$rules,$message);
        if($validator->passes()){
            $input['clert'] = session('admin') ? session('admin') : 1;
            $res = ProAttr::create($input);
            if($input['com_id'] != 0){
                $comData = ProCombination::select('id','conbination')->where('id',$input['com_id'])->get()->first();
                $comData->conbination = empty($comData['conbination']) ? $res->id : $comData->conbination .'_'.$res->id;
                $comData->save();
            }
            return $res ? redirect('admin/pro_attr'): back()->with('errors','数据添加失败！');
        }else{
            return back()->withErrors($validator);
        }
    }

    //添加属性页面
    //| GET|HEAD  | admin/pro_attr/create | .create
    public function create()
    {
        $comData = ProCombination::select('id','name','state')->where('state','0')->get()->toArray();
        return view('admin.product.proattr.attrChange', compact('comData'));
    }

    //编辑属性页面
    //| GET|HEAD | admin/pro_attr/{pro_attr}/edit | .edit
    public function edit($attr_id)
    {
        $data = ProAttr::find($attr_id);
        $comData = ProCombination::select('id','name','state','conbination')->where('state','0')->get()->toArray();
        $comId = 0;
        foreach($comData as $v){
            if(in_array($attr_id, explode('_', $v['conbination'])))
                $comId = $v['id'];
        }
        return view('admin.product.proattr.attrChange',compact('data','comData','comId'));
    }

    //编辑属性提交
    //| PUT|PATCH | admin/pro_attr/{pro_attr} | .update
    public function update($attr_id)
    {
        $input = Input::except('_method','_token','s');//dd($input);
        $rules = [
            'name'=>'required|max:24|unique:pro_attr,name'.$attr_id,
            'status'=>'required|between:0,2',
            'state'=>'required|between:0,1',
        ];

        $message = [
            'name.required'=>'请填写属性名称！',
            'name.max' => '属性名不能超过24个字符！',
            'name.unique' => '属性名已存在！',
            'status.required'=>'请选择属性类型！',
            'status.between'=>'类型选择错误！',
            'state.required'=>'请选择属性状态！',
            'state.between'=>'状态选择错误！',
        ];

        $validator = Validator::make($input,$rules,$message);
        if($validator->fails())
            return back()->withErrors($validator);//return $validator->errors()->first();

        $res = ProAttr::where('id',$attr_id)->get()->first();
        /*if($input['com_id'] != 0){
            $comData = ProCombination::select('id','conbination')->where('id',$input['com_id'])->get()->first();
            $comData->conbination = empty($comData['conbination']) ? $res->id : $comData->conbination .'_'.$res->id;
            $comData->save();
        }
        unset($input['com_id']);*/
        $res = $res->update($input);
        return $res ? redirect('admin/pro_attr'): back()->with('errors','属性更新失败！');
    }

    //显示属性信息
    //| GET|HEAD | admin/pro_attr/{pro_attr} | .show
    public function show($attr_id)
    {

    }

    //删除属性
    //| DELETE    | admin/pro_attr/{pro_attr}        | .destroy
    public function destroy($attr_id)
    {
        //删除前判断分类是否使用
        foreach(ProCombination::select('id','conbination')->get()->toArray() as $attr){
            $attrArr = explode('_', $attr['conbination']);
            if(in_array($attr_id, $attrArr)){
                $conbination = '';
                foreach($attrArr as $v){
                    if($attr_id == $v)
                        continue;
                    $conbination .= $v . '_';
                }
                ProCombination::where('id',$attr['id'])->update(['conbination'=>trim($conbination, '_')]);
            }
        }
        $res = ProAttr::where('id',$attr_id)->delete();
        return $res ? ['status' => 1, 'msg' => '删除成功！']: ['status' => 0, 'msg' => '删除失败！'];
    }

    //批量删除
    public function dels()
    {
        //DB::table('xx')->whereIn('primaryKey',[1,3,5])->update(['status'=>1]);
        $input = Input::get('delitems');//return ['state'=> 0, 'data'=>$input];
        foreach($input as $id){
            foreach(ProCombination::select('id','conbination')->get()->toArray() as $attr){
                $attrArr = explode('_', $attr['conbination']);
                if(in_array($id, $attrArr)){
                    $conbination = '';
                    foreach($attrArr as $v){
                        if($id == $v)
                            continue;
                        $conbination .= $v . '_';
                    }
                   ProCombination::where('id',$attr['id'])->update(['conbination'=>trim($conbination, '_')]);
                }
            }
            ProAttr::where('id',$id)->delete();
        }
        return ['state'=>'1', 'msg'=>'删除成功！'];//redirect('admin/product');
    }

}
