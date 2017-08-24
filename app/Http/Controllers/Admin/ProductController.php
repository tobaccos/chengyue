<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class ProductController extends ProBaseController
{
    //
    //产品列表
    //| GET|HEAD | admin/product | .index
    public function index()
    {
        $res = $this->showIndex('product');
        return view('admin.product.promanage.proList',$res);
    }

    //添加产品提交
    //| POST | admin/product | .store
    public function store()
    {
        $input = Input::except('_token','s');
        $res = $this->addData('product', 'add', $input);
        if($res['code'] == 1){
            //return $res['state'] ? redirect('admin/product'): back()->with('errors','数据添加失败！');
            if($res['state'])
                return ['state'=>1, 'msg'=>'添加成功', 'url'=>url('admin/product')];
            else
                return ['state'=>0, 'msg'=>'添加失败！', 'url'=>''];
        }elseif($res['code'] == 0){
            //return back()->withErrors($res['state']);
            return ['state'=>0, 'msg'=>$res['state'], 'url'=>''];
        }
    }

    //添加产品页面
    //| GET|HEAD  | admin/product/create | .create
    public function create()
    {
        $res = $this->addView();
        return view('admin.product.promanage.proAdd', $res);
    }

    //编辑产品页面
    //| GET|HEAD | admin/product/{pro_attr}/edit | .edit
    public function edit($pro_id)
    {
        $res = $this->editView('product', $pro_id);
        return view('admin.product.promanage.proChange',$res);
    }

    //编辑产品提交
    //| PUT|PATCH | admin/product/{pro_attr} | .update
    public function update($pro_id)
    {
        $input = Input::except('_method','_token','s');//dd($input);
        $res = $this->addData('product', 'edit', $input, $pro_id);
        if($res['code'] == 1){
            if($res['state'])
                return ['state'=>1, 'msg'=>'修改成功', 'url'=>url('admin/product')];
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
        return $this->copyData('product', $copy_id);
    }

    //删除产品
    //| DELETE    | admin/product/{pro_attr}        | .destroy
    public function destroy($pro_id)
    {
        return $this->del('product', $pro_id) ? ['status' => 1, 'msg' => '删除成功！']: ['status' => 0, 'msg' => '删除失败！'];
    }

    //批量删除
    public function dels()
    {
        $input = Input::get('delitems');//return ['state'=> 0, 'data'=>$input];
        $this->allDel('product', $input);
        return ['state'=>'1', 'msg'=>'删除成功！'];//redirect('admin/product');
    }

}
