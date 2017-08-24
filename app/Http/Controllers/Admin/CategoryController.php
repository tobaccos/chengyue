<?php

namespace App\Http\Controllers\Admin;

use App\Http\Models\Activity;
use App\Http\Models\Category;
use App\Http\Models\PreBuy;
use App\Http\Models\Product;
use App\Http\Models\Recommend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use DB;

class CategoryController extends CommonController
{
    //分类列表
    //| GET|HEAD | admin/category | category.index
    public function index()
    {
        $data = Category::orderBy('sort','desc')->paginate(10);
        return view('admin.product.proclass.classList')->with('data', $data);
    }

    //添加分类提交
    //| POST | admin/category | category.store
    public function store()
    {
        $input = Input::except('_token');
        $rules = [
            'name'=>'required|unique:pro_type',
        ];

        $message = [
            'name.required'=>'请填写分类名称！',
            'name.unique'=>'分类名称已存在！',
        ];
        $validator = Validator::make($input,$rules,$message);
        if($validator->passes()){
            $input['clert'] = session('admin') ? session('admin') : 1;
            $input['pic'] = $input['pic'] ? $input['pic']: '';
            $res = Category::create($input);
            return $res ? redirect('admin/category'): back()->with('errors','数据添加失败！');
        }else{
            return back()->withErrors($validator);
        }
    }

    //添加分类页面
    //| GET|HEAD  | admin/category/create | category.create
    public function create()
    {
        return view('admin.product.proclass.classChange');
    }

    //编辑分类页面
    //| GET|HEAD | admin/category/{category}/edit | category.edit
    public function edit($cate_id)
    {
        $data = Category::find($cate_id);
        return view('admin.product.proclass.classChange',compact('data'));
    }

    //编辑分类提交
    //| PUT|PATCH | admin/category/{category} | category.update
    public function update($cate_id)
    {
        $input = Input::except('_method','_token');
        $rules = [
            'name'=>'required|unique:pro_type,name,'.$cate_id,
        ];

        $message = [
            'name.required'=>'请填写分类名称！',
            'name.unique'=>'分类名称已存在！',
        ];

        $validator = Validator::make($input,$rules,$message);
        if($validator->passes()){
            $input['clert'] = session('admin') ? session('admin') : 1;
            $input['pic'] = $input['pic'] ? $input['pic']: '';
            $res = Category::where('id',$cate_id)->update(array_only($input,['name','state','status','pic','clert']));
            return $res ? redirect('admin/category'): back()->with('errors','分类信息更新失败！');
        }else{
            return back()->withErrors($validator);
        }
    }

    //显示分类信息
    //| GET|HEAD | admin/category/{category} | category.show
    public function show($cate_id)
    {

    }

    //删除分类
    //| DELETE    | admin/category/{category}        | category.destroy
    public function destroy($cate_id)
    {
        //删除前判断分类是否使用
        if(Product::where('type_id',$cate_id)->first() || Activity::where('type_id',$cate_id)->first() || PreBuy::where('type_id',$cate_id)->first() || Recommend::where('type_id',$cate_id)->first()){
            return ['status' => 0, 'msg' => '该分类正在被使用！'];
        }else{
            $data = Category::where('id',$cate_id)->first();
            delFile(public_path(PRO_CATE_IMG_PATH) . $data->pic);
            $res = $data->delete();
            return $res ? ['status' => 1, 'msg' => '分类删除成功！']: ['status' => 0, 'msg' => '分类删除失败！'];
        }
    }

    /**
     *  分类排序
     * @param Request $request
     */
    public function sort(Request $request)
    {
        $input = $request -> except('s');
        $res = DB::table('pro_type')->where('id',$input['id']) -> update(['sort'=> $input['sort']]);
        if($res){
            return 200;
        }else{
            return 404;
        }
    }
}
