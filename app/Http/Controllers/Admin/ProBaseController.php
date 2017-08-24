<?php

namespace App\Http\Controllers\Admin;

use App\Http\Models\Category;
use App\Http\Models\ProAttr;
use App\Http\Models\ProCombination;
use App\Http\Models\Product;
use App\Http\Models\Activity;
use App\Http\Models\Recommend;
use App\Http\Models\PreBuy;
use App\Http\Models\UserCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

/*
 *
 * $model
 *      product     activity    recommend   prebuy
 * */
class ProBaseController extends CommonController
{
    protected $rules = [
        'name'=>'required|max:30',
        'state'=>'required|between:0,1',
        'type_id'=>'required|min:1',
        //'pic'=>'required',
//        'content'=>'required',
        //'com_id'=>'required|min:1',
        'attr'=>'required',
    ];

    protected $message = [
        'name.required'=>'请填写产品名称！',
        'name.max'=>'产品名称不能超过30个字符！',
        'state.required'=>'请选择产品状态！',
        'state.between'=>'产品状态错误！',
        'type_id.required'=>'请选择产品分类！',
        'type_id.min'=>'分类信息选择错误！',
        //'pic.required'=>'产品图片不能为空！',
//        'content.required'=>'请填写产品详情！',
        //'com_id.required'=>'产品组合不能为空！',
        //'com_id.min'=>'产品组合选择错误！',
        'attr.required'=>'请添加属性组合！',
    ];
    //
    //产品列表
    public function showIndex($model)
    {
        //?order=id_desc&type_id=0&start=null&end=null&keyword=
        $input = filter_var_array(Input::all(), FILTER_SANITIZE_STRING);
        $where = [];
        if(isset($input['type_id']) && $input['type_id'] > 0)
            $where[] = ['type_id','=',$input['type_id']];
        if(isset($input['start']) && !empty($input['start']))
            $where[] = ['updated_at','>=',strtotime($input['start'])];
        if(isset($input['end']) && !empty($input['end']))
            $where[] = ['updated_at','<=',strtotime($input['end'])];
        //上传到生成环境出错
        if(!isset($input['start']))
            $where[] = ['updated_at','>=',strtotime('1990/01/01')];

        $order = isset($input['order']) ? $input['order']: 'id_desc';
        //$order = explode('_', $order);
        $field = substr($order, 0, strrpos($order, '_'));
        $order = substr($order, strrpos($order, '_') + 1);

        $cateData = Category::select('id','name','state')->where('state','0')->get()->toArray();

        if($model == 'product')
            $data = isset($input['keyword']) ?  Product::where($where)->whereRaw('instr(name, \''. $input['keyword'] .'\') > 0')->orderBy($field,$order)->paginate(10): Product::where($where)->orderBy($field,$order)->paginate(10);
        elseif($model == 'activity')
            $data = isset($input['keyword']) ?  Activity::where($where)->whereRaw('instr(name, \''. $input['keyword'] .'\') > 0')->orderBy($field,$order)->paginate(10): Activity::where($where)->orderBy($field,$order)->paginate(10);
        elseif($model == 'recommend')
            $data = isset($input['keyword']) ?  Recommend::where($where)->whereRaw('instr(name, \''. $input['keyword'] .'\') > 0')->orderBy($field,$order)->paginate(10): Recommend::where($where)->orderBy($field,$order)->paginate(10);
        elseif($model == 'prebuy')
            $data = isset($input['keyword']) ?  PreBuy::where($where)->whereRaw('instr(name, \''. $input['keyword'] .'\') > 0')->orderBy($field,$order)->paginate(10): PreBuy::where($where)->orderBy($field,$order)->paginate(10);

        return ['data'=>$data, 'cateData'=>$cateData];
    }

    //添加产品提交
    public function addData($model, $action, $input, $pro_id=0, $rules='', $message='')
    {
        if(empty($input['fileurl_tmp'][0]))
            return ['code'=>0, 'state'=>'请上传产品图片！'];
        if(empty($rules))
            $rules = $this->rules;
        if(empty($message))
            $message = $this->message;
		//"com_id" => null
        if($input['com_id'] === null){
            $res = ProCombination::where('name', $input['com_id_sele'])->select('id')->first();
            $input['com_id'] = $res ? $res->id : 0;
        }

        $validator = Validator::make($input,$rules,$message);
        if($validator->passes()){
            //添加记录人
            $input['clert'] = session('admin') ? session('admin') : 1;
            //添加产品图片
            if(isset($input['fileurl_tmp'])){
                foreach($input['fileurl_tmp'] as $v){
                    $input['pic'] .= '|' . $v;
                }
            }else{
                $input['pic'] = '';
            }
            //添加缩略图
            if(empty($input['thumbing'])){
                if(!empty($input['pic']))
                    $input['thumbing'] = $input['fileurl_tmp'][0];//缩略图为空取上传图片第一张
                else
                    $input['thumbing'] = '';
            }
            if(empty($input['rate']))
                $input['rate'] = 0;
            if(!isset($input['cue']))
                $input['cue'] = '';
            //处理编辑器图片
            //取src
			//$preg = "|src=(.*) |U";
			$preg = "/(href|src)=([\"|']?)([^\"'>]+.(jpg|JPG|jpeg|JPEG|gif|GIF|png|PNG))/i";
            if(preg_match_all($preg, $input['content'], $imgs)){
                foreach($imgs[3] as $v){
                    $img = trim($v, '"');
					$img = strstr($img, '"', true) ? strstr($img, '"', true): $img;
                    $newImg = str_replace('/uploads/temp/ueditor/image/','/uploads/product/ueditor/image/',$img);
                    //建立文件夹
                    $dirArr = explode('/', $newImg);
                    $dir = '';
                    for($i = 0; $i< count($dirArr) - 1; $i++){
                        if(!empty($dirArr[$i])){
                            $dir .= $dirArr[$i] . '/';
                            if(!is_dir(public_path($dir)))
                                mkdir(public_path($dir));
                        }
                    }
                    //移动文件
                    if(is_file(public_path($img)))
                        rename(ltrim($img, '/'), ltrim($newImg, '/'));
                }
                //替换
                $input['content'] = str_replace('/uploads/temp/ueditor/image/','/uploads/product/ueditor/image/',$input['content']);
            }

            //增加产品属性
            $input['con_attr'] = [];
            $attrCount = count($input['attr']['price']['value']);//属性数量
            for($i = 0; $i<$attrCount; $i++){
                foreach($input['attr'] as $k => $v){
                    //属性颜色
                    $input['con_attr'][$i]['color'] = $input['colorCh'][$i];
                    //
                    if($k === 'price')
                        $input['con_attr'][$i]['price'] = $v['value'][$i];
                    elseif($k === 'unit')
                        $input['con_attr'][$i]['unit'] = $v['value'][$i];
                    elseif($k === 'rate')
                        $input['con_attr'][$i]['rate'] = $v['value'][$i];
                    else{
                        foreach($v as $key => $vv){
                            if($key === 'name')
                                $input['con_attr'][$i][$k]['name'] = $vv;
                            elseif($key === 'type')
                                $input['con_attr'][$i][$k]['type'] = $vv;
                            else{
                                if(isset($vv[$i]))
                                    $input['con_attr'][$i][$k]['value'] = $vv[$i];
                                elseif(isset($vv['name']))
                                    $input['con_attr'][$i][$k]['value'] = ['name'=>$vv['name'][$i], 'value'=>$vv['value'][$i]];
                                elseif ($vv[$i] === null)//更新页面后输入框为空为null
                                    $input['con_attr'][$i][$k]['value'] = null;
                            }
                        }
                    }
                }
            }
            $input['min'] = $input['max'] = '';
            foreach($input['con_attr'] as $v){
                if(empty($v['price']) || ($v['price']<0) || ($v['price']>999999))
                    return ['code'=>0, 'state'=>'请输入正确的产品价格！'];
                if(empty($input['min']))
                    $input['min'] = $v['price'];
                elseif($input['min'] > $v['price'])
                    $input['min'] = $v['price'];
                //
                if(empty($input['max']))
                    $input['max'] = $v['price'];
                elseif($input['max'] < $v['price'])
                    $input['max'] = $v['price'];
            }
            if($model == 'product')
                $input['con_attr'] = json_encode($input['con_attr']);
            else{
                $input['com_attr'] = json_encode($input['con_attr']);
                unset($input['con_attr']);
            }
            $input['show_time'] = strtotime($input['show_time']);
            if(isset($input['end_time']))
                $input['end_time'] = strtotime($input['end_time']);

            if($action == 'add'){
                if($model == 'product')
                    $res = Product::create($input);
                elseif($model == 'activity')
                    $res = Activity::create($input);
                elseif($model == 'recommend')
                    $res = Recommend::create($input);
                elseif($model == 'prebuy')
                    $res = PreBuy::create($input);
            }elseif($action == 'edit'){
                if($model == 'product')
                    $res = Product::where('id',$pro_id)->update(array_only($input,['name','clert','state','type_id','con_attr','pic','content','thumbing','show_time','cue','code','com_id','min','max','rate']));
                elseif($model == 'activity')
                    $res = Activity::where('id',$pro_id)->update(array_only($input,['name','clert','state','type_id','com_attr','pic','content','thumbing','show_time','cue','com_id','min','max','number','rate']));
                elseif($model == 'recommend')
                    $res = Recommend::where('id',$pro_id)->update(array_only($input,['name','clert','state','type_id','com_attr','pic','content','thumbing','show_time','cue','com_id','min','max','number','rate']));
                elseif($model == 'prebuy')
                    $res = PreBuy::where('id',$pro_id)->update(array_only($input,['name','clert','state','type_id','com_attr','number','pic','content','thumbing','show_time','end_time','cue','com_id','min','max','rate']));
            }
            return ['code'=>1, 'state'=>$res];
            //return $res ? redirect('admin/product'): back()->with('errors','数据添加失败！');
        }else{
            return ['code'=>0, 'state'=>$validator->messages()->first()];
            //return back()->withErrors($validator);
        }
    }

    //添加产品页面
    public function addView()
    {
        $catData = Category::select('id','name')->get();//分类
        $comData = ProCombination::select('id','name')->where('state',0)->get();//属性
        return ['catData'=>$catData,'comData'=>$comData];
    }

    //编辑产品页面
    //| GET|HEAD | admin/product/{pro_attr}/edit | .edit
    public function editView($model, $pro_id)
    {
        if($model == 'product')
            $data = Product::find($pro_id);//产品数据
        elseif($model == 'activity')
            $data = Activity::find($pro_id);
        elseif($model == 'recommend')
            $data = Recommend::find($pro_id);
        elseif($model == 'prebuy')
            $data = PreBuy::find($pro_id);
        $catData = Category::select('id','name')->get();//分类
        $comData = ProCombination::select('id','name')->where('state',0)->get();//属性
        //产品图片处理
        $picList = explode('|',trim($data['pic'],'|'));
        //产品属性组处理
        if(isset($data['con_attr']))
            $data['con_attr'] = json_decode($data['con_attr'], true);
        else
            $data['con_attr'] = json_decode($data['com_attr'], true);
        $data['show_time'] = date('Y-m-d H:i:s',$data['show_time']);
        if(isset($data['end_time']))
            $data['end_time'] = date('Y-m-d H:i:s',$data['end_time']);
        return ['data'=>$data,'picList'=>$picList,'catData'=>$catData,'comData'=>$comData];
    }

    //复制产品
    public function copyData($model, $copy_id)
    {
        if($model == 'product')
            $data = Product::where('id',$copy_id)->first()->toArray();
        elseif($model == 'activity')
            $data = Activity::where('id',$copy_id)->first()->toArray();
        elseif($model == 'recommend')
            $data = Recommend::where('id',$copy_id)->first()->toArray();
        elseif($model == 'prebuy')
            $data = PreBuy::where('id',$copy_id)->first()->toArray();

        if(empty($data))
            return ['status'=>0, 'msg'=>'产品错误'];
        else{
            unset($data['id']);
            $data['name'] = 'new_'.$data['name'];
            //
            if($model == 'product')
                $res = Product::create($data);
            elseif($model == 'activity')
                $res = Activity::create($data);
            elseif($model == 'recommend')
                $res = Recommend::create($data);
            elseif($model == 'prebuy')
                $res = PreBuy::create($data);

            return $res ? ['status'=>1, 'msg'=>'复制成功']: ['status'=>0, 'msg'=>'复制失败'];
        }

    }


    //删除产品
    //| DELETE    | admin/product/{pro_attr}        | .destroy
    public function del($model, $pro_id)
    {
        if($model == 'product')
            $res = Product::where('id',$pro_id)->delete();
        elseif($model == 'activity')
            $res = Activity::where('id',$pro_id)->delete();
        elseif($model == 'recommend')
            $res = Recommend::where('id',$pro_id)->delete();
        elseif($model == 'prebuy')
            $res = PreBuy::where('id',$pro_id)->delete();
        //删除收藏
        UserCollection::where('pro_id',$pro_id)->delete();
        //删除图片
        return $res;
    }

    //批量删除
    public function allDel($model, $input)
    {
        foreach($input as $id){
            if($model == 'product')
                Product::where('id',$id)->delete();
            elseif($model == 'activity')
                Activity::where('id',$id)->delete();
            elseif($model == 'recommend')
                Recommend::where('id',$id)->delete();
            elseif($model == 'prebuy')
                PreBuy::where('id',$id)->delete();
            //删除收藏
            UserCollection::where('pro_id',$id)->delete();
            //删除图片
        }
        return 1;
    }

    function uploadify( $pathType = 1, $newImageName = '')
    {
        $file = Input::file('Filedata');//return dd($file);
        if($pathType == 1)
            $pathInfo = PRO_IMG_PATH;
        elseif($pathType == 2)
            $pathInfo = PRO_CATE_IMG_PATH;
        elseif($pathType == 3)
            $pathInfo = AD_IMG_PATH;
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

    public function ajaxAttrAdd()
    {
        /*
         * array:3 [
  "com_name" => "44"
  "attr" => array:4 [
    0 => "1"
    1 => "12"
    2 => "2"
    3 => "33"
  ]
  "attr_type" => array:4 [
    0 => "0"
    1 => "0"
    2 => "1"
    3 => "2"
  ]
]
         * */
        $input = Input::except('_token');
        $clert = session('admin') ? session('admin'): '1';
        $res = ProCombination::create(['name'=>$input['com_name'],'clert'=> $clert,'state'=>'0']);
        $com_id = $res->id;//新建属性组的id
        $attr_id = '';
        foreach($input['attr'] as $k => $attr){
            if($attr !== null){
                $res = ProAttr::create(['name'=>$attr, 'clert'=>$clert, 'state'=>'0', 'status'=>$input['attr_type'][$k]]);
                $attr_id .= '_'.$res->id;
            }else{
                ProCombination::where('id',$com_id)->delete();
                return 0;
            }

        }
        $attr_id = trim($attr_id, '_');
        ProCombination::where('id',$com_id)->update(['conbination'=>$attr_id]);
        return $com_id;
    }

    //ajax返回属性分类
    public function getAjaxComCate()
    {
        return ProCombination::select('id','name')->where('state','0')->get()->toJson();
    }

    //ajax返回属性分类内容
    public function getAjaxCom($com_id)
    {
        $comData = ProCombination::select('id','name','conbination')->where('id',$com_id)->where('state',0)->get()->first();
        $conbination = $comData->conbination;
        $comArr = explode('_', $conbination);
        $ret = [];
        foreach($comArr as $v){
            $ret[] = ProAttr::select('id', 'name', 'state', 'status')->where('id', $v)->where('state','0')->get()->first()->toArray();
        }
        return $ret;//json_encode($ret,true);
    }
}
