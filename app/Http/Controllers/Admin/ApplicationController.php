<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class ApplicationController extends CommonController
{
    //返回提现列表首页
    public function index(Request $request)
    {
        $data = DB::table('user_account as ua')
                    -> join('users','users.id','=','ua.user_id')
                    -> select('users.name','ua.id','ua.created_at','ua.money','ua.bank_name','ua.bank_num','ua.remark','ua.created_at','ua.state')
                    -> paginate(10);
        //处理时间
        foreach($data as $k => $v)
        {
            $v -> created_at = date('Y-m-d H:i:s',$v -> created_at);
        }
        return view('admin.user.application.appList',['data' => $data,'request' => $request -> all() ]);
    }

    //申请提现通过
    public function adpot($id)
    {
        //查询数据是否正确
        $data = DB::table('user_account') -> where('id',$id) -> first();
        if($data -> state == 0)
        {
            DB::beginTransaction();
            try{
                $tdata = 1;
                //更新提现表数据
                $res = DB::table('user_account') -> where('id',$id) -> update(['state' => $tdata]);
                //更新用户信息表提现总金额
                    //查询一提现的总金额
                $money = DB::table('user_info') -> select('acc_amount') -> where('user_id',$id) -> first();
                //处理数据（转成数字类型）
                $amount = $money -> acc_amount;
                //更新数据
                $money = $data->money + $amount ;
//                var_dump($money);die;
                $res2 = DB::table('user_info') -> where('user_id',$id) -> update(['acc_amount' => $money]);

                 DB::commit();
            }catch (\Exception $e) {
                DB::rollBack();
                return back() -> with(['info' => '请重试']);
            }
            //返回页面
            if($res || $res2)
            {
                return redirect('admin/user/application/appList')-> with(['info' => '已通过']);
            }else
            {
                return back() -> with(['info' => '请重试']);
            }
        }else
        {
            return back() -> with(['info' => '请查看是否已通过']);
        }
    }

    //申请提现驳回
    public function reject(Request $request,$id)
    {
        //数据验证
        $this -> validate($request,[
            'reject' => 'required',
        ],[
            'reject.required' => '驳回原因不能为空',
        ]);
        $reject = $request ->except('_token','s');
//var_dump($reject['reject']);die;
        //确认数据是否真实
        $data = DB::table('user_account') -> where('id',$id) -> first();
//        var_dump($data);die;
        if($data -> state == 0)
        {
            //更新数据
            $num['state'] = 2;
            $num['reject'] = $reject['reject'];
            $res = DB::table('user_account') -> where('id',$id) -> update($num);
            if($res)
            {
                $data =  DB::table('user_account') -> where('id',$id) -> first();
                $res2 = DB::table('user_info') -> where('user_id',$data -> user_id) ->increment('virtualcurrency',$data -> money);
                if($res2)
                {
                    return redirect('admin/user/application/appList') -> with(['info' => '申请已驳回']);
                }else{
                     return back() -> with(['info' => '请重试']);
                }
            }else
            {
                return back() -> with(['info' => '请重试']);
            }
        }else
        {
            return back() -> with(['info' => '驳回失败，请查看是否已处理']);
        }
    }

    //删除提现申请
    public function delete()
    {
        $id = $_GET;
        //查询此条记录是否已被用户删除
        $data = DB::table('user_account') -> where('id',$id) -> first();
        if($data -> is_delete == 1)
        {
            //执行删除
            $res = DB::table('user_account') -> delete($id);
            if($res)
            {
               echo '删除成功';
            }else{
                echo '删除失败';
            }
        }else{
            echo '删除失败(用户未删除前不能删除记录)';
        }

    }


    //批量删除
    public function dels()
    {
        $ids = $_GET;
        if(empty($ids))
        {
            echo '删除失败';
        }
        //查询此条记录是否已被用户删除
        foreach($ids as $value) {
            // DB::beginTransaction();
            //    try{
            //        $data = DB::table('user_account') -> where('id',$v) -> where('is_delete', 1) -> delete($v);
            //        DB::commit();
            //    }catch (\Exception $e) {
            //        return '删除失败(用户未删除前不能删除记录)';
            //        DB::rollBack();
            //    }

            if($value['0'] == 'on' || $value['0'] == '')
            {
                array_shift($value);
            }
            $die = [];
            $success = [];
            foreach ($value as $key => $v) {
                $data = DB::table('user_account') -> where('id',$v) -> where('is_delete', 1) -> first();
                if(empty($data))
                {
                    $die[$v] = $v;
                }else{
                    $success[$v] = $v;
                    DB::table('user_account') -> delete($v);
                }
            }
            if(!empty($die))
            {
              $die = implode('、',$die);
              echo "编号为".$die."删除失败！<br/>失败原因：用户删除前不可删除<br/><br/>";
            }
            if(!empty($success))
            {
              $success = implode('、',$success);
              echo "编号为[".$success."]删除成功！<br/>";
            }

        }
    }
    //返回分成列表
    public function rebate(Request $request)
    {
        $keywords = $request -> input('keywords','');
        //查询数据
        $data = DB::table('rebate_log')
                -> join('users','users.id','=','rebate_log.user_id')
                -> join('user_info','user_info.user_id','=','users.id')
                -> select('users.id','users.name as uname','users.created_at','user_info.rebate_amount','user_info.acc_amount','rebate_log.buy_user_id')
               -> whereRaw('instr(name, "'. $keywords .'") > 0')
                -> paginate(10);

        foreach($data as $k => $v)
        {
            //处理时间
            $v -> created_at = date('Y-m-d H:i:s',$v -> created_at);
            //处理未提现金额
            $v -> acc_amount = $v ->rebate_amount -$v -> acc_amount;
        }
                // var_dump($data);die;
        return view('admin/user/application/rebate',['data' => $data,'request' => $request->all()]);
    }

    //查看详情
    public function detail(Request $request,$id)
    {
        //判断是否有起止时间
        if($request -> input('start',''))
        {
            $start = strtotime($request -> input('start',''));
        }else
        {
            $start = 0;
        }
        if($request -> input('end',''))
        {
            $end = strtotime($request -> input('end',''));
        }else
        {
            $end = time();
        }
//        var_dump($start);
        $keyword = $request -> input('keyword','');
        //查询详细数据
            $data = DB::table('rebate_log as rl')
                -> join('users','rl.buy_user_id','=','users.id')
                -> select('users.name','rl.id','rl.order_sn','rl.pro_price','rl.money','rl.created_at','rl.confirm','rl.state')
                -> where('rl.buy_user_id',$id)
                -> whereRaw('instr(name, \''. $keyword .'\') > 0')
                -> whereBetween('confirm',[$start,$end])
                -> get();
        $oldId = $id;
        //处理时间
        foreach($data as $k => $v)
        {
            $v -> created_at = date('Y-m-d H:i:s',$v -> created_at);
            $v -> confirm = date('Y-m-d H:i:s',$v -> confirm);
        }
        return view('admin.user.application.rebateDetail',['data' => $data,'oldId'=>$oldId]);
    }

    //删除分成记录
    public function redel()
    {
        $id = $_GET['id'];
        //查询此条记录是否已被用户删除
        $data = DB::table('rebate_log') -> where('id',$id) -> first();
        if($data -> is_delete == 1)
        {
            //执行删除
            $res = DB::table('rebate_log') -> delete($id);
            if($res)
            {
                echo '删除成功';
            }else{
                echo '删除失败';
            }
        }else{
            echo '删除失败(用户未删除前不能删除记录)';
        }
    }

    //查看原因
    public function show()
    {
        $id = $_GET;
        //查询数据
        $data = DB::table('user_account')-> where('id',$id) -> value('reject');
        echo $data;
    }

    //押金提现页面
    public function deposit()
    {
        return view('admin.user.application.deposit');
    }
}
