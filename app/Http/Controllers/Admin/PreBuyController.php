<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Input;

class PreBuyController extends ProBaseController
{
    //产品列表
    //| GET|HEAD | admin/product | .index
    public function index()
    {
        $res = $this->showIndex('prebuy');
        return view('admin.actType.timelimit.list',$res);
    }

    //添加产品提交
    //| POST | admin/product | .store
    public function store()
    {
        $rules = $this->rules;
        $message = $this->message;

        $rules['number'] = 'required|integer';
        $message['number.required'] = '数量不能为空！';
        $message['number.integer'] = '数量必须是数字！';

        $input = Input::except('_token','s');
        $res = $this->addData('prebuy', 'add', $input, 0, $rules, $message);
        if($res['code'] == 1){
            if($res['state'])
                return ['state'=>1, 'msg'=>'添加成功', 'url'=>url('admin/pre_buy')];
            else
                return ['state'=>0, 'msg'=>'添加失败！', 'url'=>''];
        }elseif($res['code'] == 0){
            return ['state'=>0, 'msg'=>$res['state'], 'url'=>''];
        }
    }

    //添加产品页面
    //| GET|HEAD  | admin/product/create | .create
    public function create()
    {
        $res = $this->addView();
        return view('admin.actType.timelimit.add', $res);
    }

    //编辑产品页面
    //| GET|HEAD | admin/product/{pro_attr}/edit | .edit
    public function edit($pro_id)
    {
        $res = $this->editView('prebuy', $pro_id);
        return view('admin.actType.timelimit.change',$res);
    }

    //编辑产品提交
    //| PUT|PATCH | admin/product/{pro_attr} | .update
    public function update($pro_id)
    {
        $rules = $this->rules;
        $message = $this->message;

        $rules['number'] = 'required|integer';
        $message['number.required'] = '数量不能为空！';
        $message['number.integer'] = '数量必须是数字！';

        $input = Input::except('_method','_token','s');
        $res = $this->addData('prebuy', 'edit', $input, $pro_id, $rules, $message);
        if($res['code'] == 1){
            if($res['state'])
                return ['state'=>1, 'msg'=>'修改成功', 'url'=>url('admin/pre_buy')];
            else
                return ['state'=>0, 'msg'=>'修改失败！', 'url'=>''];
        }elseif($res['code'] == 0){
            return ['state'=>0, 'msg'=>$res['state'], 'url'=>''];
        }
    }

    //显示产品信息
    //| GET|HEAD | admin/product/{pro_attr} | .show
    public function show($pro_id)
    {

    }

    public function copy($copy_id)
    {
        return $this->copyData('prebuy', $copy_id);
    }

    //删除产品
    //| DELETE    | admin/product/{pro_attr}        | .destroy
    public function destroy($pro_id)
    {
        return $this->del('prebuy', $pro_id) ? ['status' => 1, 'msg' => '删除成功！']: ['status' => 0, 'msg' => '删除失败！'];
    }

    //批量删除
    public function dels()
    {
        //DB::table('xx')->whereIn('primaryKey',[1,3,5])->update(['status'=>1]);
        $input = Input::get('delitems');//return ['state'=> 0, 'data'=>$input];
        $this->allDel('prebuy', $input);
        return ['state'=>'1', 'msg'=>'删除成功！'];//redirect('admin/product');
    }
}
