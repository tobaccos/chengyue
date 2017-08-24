<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class CommentController extends Controller
{
    //列表
    public function index(Request $requres){
    	$oId = DB::table('comment')
        -> join('orders','comment.order_id','=','orders.id')
        -> select('comment.order_id','orders.table_type','comment.id')
        -> paginate(5);
        // dd($oId);die;
        $data = [];
    	foreach ($oId as $v){
            if($v -> table_type == '1')
            {
                $class = 'product';
            }elseif($v -> table_type == '2')
            {
                $class = 'recommend';
            }elseif($v -> table_type == '3')
            {
                $class = 'pre_buy';
            }elseif($v -> table_type == '4')
            {
                $class = 'activity';
            }

            $data[] = DB::table('comment')
                -> join($class,'comment.pro_id', '=', $class.'.id')
                -> join('users','comment.user_id' ,'=', 'users.id')
                -> select('users.name as uname',$class.'.name as pname','comment.created_at as ctime','comment.state','comment.text','comment.content','comment.id','comment.image')
                ->where('comment.id',$v ->id)
                -> get()
                ->toArray();
        }
    	return view('admin/critical/ciritical',['data' => $data,'oId' => $oId,'request' => $requres -> all()]);
    }

    //删除
    public function delete(Request $request,$id){
        $data = $request -> except('_token','s');
    	$state = DB::table('comment') -> where('id',$id) -> value('state');

    	//判断是否显示
    	if($state == '1')
    	{
    		echo '此回复已显示,不可删除!';die;
    	}

    	//进行删除
    	$res = DB::table('comment') -> delete($id);
    	 if($res)
        {
            return '删除成功';
        }else
        {
            return '删除失败';
        }
    }

    //通过
    public function adpot(Request $request,$id){
    	$data = $request -> except('_token','s');
        //开启事物
        $row = DB::table('comment') -> where('id',$id) -> value('state');
        if($row == 1){
            return '已通过无须通过';
        }
        DB::beginTransaction();
        try{
            $res = DB::table('comment') -> where('id',$id) -> update(['state' => 1]);
            DB::commit();
            return '通过成功';
        }catch (\Exception $e) {
            DB::rollBack();
            return back() -> with(['info' => '通过失败']);
        }
    }

    //驳回
    public function reject(Request $request,$id){

        $data = $request -> except('_token','s');
        $text = $data['content'];

        $row = DB::table('comment') -> where('id',$id) -> value('state');
        if($row == 2){
            return '已驳回无须再次驳回';
        }
        //开启事物
        DB::beginTransaction();
        try{
            $res = DB::table('comment') -> where('id',$id) -> update(['state' => 2,'text' => $text]);
            DB::commit();
            return redirect('admin/critical/ciritical') -> with(['info'=> '驳回成功']);
        }catch (\Exception $e) {
            DB::rollBack();
            return back() -> with(['info' => '驳回失败']);
        }
    }
}
