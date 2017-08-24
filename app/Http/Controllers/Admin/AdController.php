<?php

namespace App\Http\Controllers\Admin;

use App\Http\Models\Ad;
use App\Http\Models\protype;

use App\Http\Models\AdPosition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdController extends CommonController
{
    //
    public function index()
    {
        $data = Ad::orderBy('id','desc')->paginate(10);
        return view('admin.ad.index',compact('data'));
    }

    public function add(Request $request)
    {
        if($request->isMethod('post')){
            $params = $request->except('_token','id');
            $rules = [
                'title' => 'required|unique:ad',
                'state' => 'required',
            ];
            $messages = [
                'title.required' => '请输入广告名称！',
                'title.unique' => '广告重复！',
                'state.required' => '请选择广告位状态！',
            ];
            $validator = Validator::make($params,$rules,$messages);
            if($validator->fails()){
                return back()->withErrors($validator);//$validator->errors()->first();
            }
            $params['type'] = 0;
            $res = Ad::create($params);
            return $res?redirect('admin/ad/index'): back()->with('errors','数据添加失败！');
        }
        //
        $posData = AdPosition::select('id','title','state')->where('state','1')->get()->toArray();
        return view('admin.ad.edit', compact('posData'));
    }

    //
    public function edit($id, Request $request)
    {
        if($request->isMethod('post')){
            $params = $request->except('_token','id');
            $rules = [
                'title' => 'required|unique:ad,title,'.$id,
            ];
            $messages = [
                'title.required' => '请输入广告名称！',
                'title.unique' => '广告名称重复！',
            ];
            $validator = Validator::make($params,$rules,$messages);
            if($validator->fails()){
                return back()->withErrors($validator);//$validator->errors()->first();
            }
            $params['type'] = 0;
            $res = Ad::where('id',$id)->update(array_only($params,['title','type','pic','url','state','position']));
            return $res?redirect('admin/ad/index'): back()->with('errors','数据添加失败！');
        }
        //
        $data = Ad::find($id);
        $posData = AdPosition::select('id','title','state')->where('state','1')->get()->toArray();
        return view('admin.ad.edit', compact('data', 'posData'));
    }

    public function del($id)
    {
        $res = Ad::where('id',$id)->delete();
        return $res ? ['status' => 1, 'msg' => '广告删除成功！']: ['status' => 0, 'msg' => '广告删除失败！'];
    }

    //广告位列表
    public function position()
    {
        $data = AdPosition::orderBy('id','desc')->paginate(10);

        return view('admin.ad.position',compact('data'));
    }

    //添加广告位
    public function pos_add(Request $request)
    {
        if($request->isMethod('post')){
            $params = $request->except('_token','id');
            $rules = [
                'title' => 'required|unique:ad_position',
                'alias' => 'required|unique:ad_position',
                'desc' => 'required',
                'state' => 'required',
            ];
            $messages = [
                'title.required' => '请输入广告位名称！',
                'title.unique' => '广告位重复！',
                'alias.required' => '请输入广告位别名！',
                'alias.unique' => '广告位别名重复！',
                'desc.required' => '请输入广告位描述！',
                'state.required' => '请选择广告位状态！',
            ];
            $validator = Validator::make($params,$rules,$messages);
            if($validator->fails()){
                return back()->withErrors($validator);//$validator->errors()->first();
            }

            $res = AdPosition::create($params);
            return $res?redirect('admin/ad/position'): back()->with('errors','数据添加失败！');
        }
        //
        return view('admin.ad.pos_edit');
    }

    public function pos_edit($id, Request $request)
    {
        if($request->isMethod('post')){
            $params = $request->except('_token','id');
            $rules = [
                'title' => 'required|unique:ad_position,title,'.$id,
                'alias' => 'required|unique:ad_position,alias,'.$id,
                'desc' => 'required',
                'state' => 'required',
            ];
            $messages = [
                'title.required' => '请输入广告位名称！',
                'title.unique' => '广告位名称重复！',
                'alias.required' => '请输入广告位别名！',
                'alias.unique' => '广告位别名重复！',
                'desc.required' => '请输入广告位描述！',
                'state.required' => '请选择广告位状态！',
            ];
            $validator = Validator::make($params,$rules,$messages);
            if($validator->fails()){
                return back()->withErrors($validator);//$validator->errors()->first();
            }

            $res = AdPosition::where('id',$id)->update(array_only($params,['title','alias','state','desc']));
            return $res?redirect('admin/ad/position'): back()->with('errors','数据添加失败！');
        }
        //
        $data = AdPosition::find($id);
        //
        return view('admin.ad.pos_edit', compact('data'));
    }

    //删除广告位
    public function pos_del($id)
    {
        //删除前判断分类是否使用
        if(Ad::where('position',$id)->first()){
            return ['status' => 0, 'msg' => '该广告位正在被使用！'];
        }else{
            $res = AdPosition::where('id',$id)->delete();
            return $res ? ['status' => 1, 'msg' => '广告位删除成功！']: ['status' => 0, 'msg' => '广告位删除失败！'];
        }
    }

}
