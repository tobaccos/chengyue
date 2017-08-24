<?php

namespace App\Http\Controllers\Home;

use Guzzle\Plugin\Cookie\Cookie;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Mail;
use PasswordBroker;
use Illuminate\Auth\Passwords\TokenRepositoryInterface;
use Illuminate\Notifications\Notifiable;
//use Illuminate\Support\Facades\Cookie;
use DB;
use Hash;

class ResetPayController extends Controller
{
    use Notifiable;

//    use  SendsPasswordResetEmails;
//    use ResetsPasswords, SendsPasswordResetEmails;
//        use CanResetPassword;

    /**
     * 重置密码发送邮件页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('emails.resetPayPass');
    }

    /**
     * 重置密码页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function resetView($token)
    {
        setcookie('back_token',$token,time()+600,'/');
        return view('emails.reset');
    }
    /**
     * 重置支付密码发送邮件
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @method post
     */
    public function send(Request $request)
    {

        $user = Auth::user();
        if(!$user){
            return redirect('/login');
        }
        $token = csrf_token();
        $reset_url = url('/resetView');
        $url = $reset_url.'/'.$token;
        if(empty($user->email)){
//            return back() -> with(['info' => '您还没有绑定邮箱，请先绑定邮箱！']);
            return '404';
        }
        $name = $user->name;
        Mail::send('emails.test',['name'=>$name, 'url'=>$url ],function($message) use ($user) {
            $to = $user->email;
            $message ->to($to)->subject('测试邮件');
        });
        setcookie('user_token',$token,time()+600,'/');
//        return back()->with(['info'=> '邮件已发送到您的邮箱，如未接收到邮件，请重新发送']);
        return '200';
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @method post
     * 重置支付密码
     */
    public function resetPay(Request $request)
    {

        $user_id = Auth::id();
        $data = $request->except('_token','s');
        if(!isset($_COOKIE['user_token'])){
            return back()->with(['info' => '重置密码超时，请重新发送邮件']);
        }
        $token = $_COOKIE['back_token'];
        $csrf_token = $_COOKIE['user_token'] ? $_COOKIE['user_token'] : '';
        if($token != $csrf_token){
            return back()->with(['info'=>"重置链接已失效,请重新发送邮件"]);
        }
        if(empty($data['password'])){
           return back()->with(['info' => '密码不能为空！']);
        }
        if($data['password'] != $data['password_confirmation']){
            return back()->with(['info' => '两次输入密码不一致']);
        }

        $password = Hash::make($data['password']);
        $res = DB::table('users')->where('id',$user_id)->update( ['pay_pass'=>$password] );
        if(!$res){
            return "重置支付密码失败，请重新设置";
        }
        setcookie('user_token',null);
        return redirect('/home/member/xiugai') ->with(['info' => '修改成功！']);



    }

    /**
     * @param Request $request
     * @method get
     * 重置支付密码页面
     */
    public function reset($token)
    {
        $this->token = $token;
        return view('emails.reset');
    }


    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('r account.')
            ->action('Reset ', url(config('app.url').route('reset', $this->token, false)))
            ->line('r action is required.');
    }


    /**
     * 重置密码
     * @param Request $request
     * @return string
     */
    public function toReset(Request $request)
    {
        $this->validate($request, $this->rules(), $this->validationErrorMessages());
        $email = $request->except('_token');
        $data = DB::Table('password_resets')->where('email',$email['email'])->first();
        $time = time();
        if(!$data){
            return '406';//没有查到用户
        }
		
        if($data->created_at+3600 < $time){
            return '405';// 时间超时
        }
		
        $password = Hash::make($email['password']);
        $res = DB::table('users')->where('email',$email['email'])->update(['password'=> $password]);
        if($res){
            return '200';
        }else{
            return '404';
        }

    }

    protected function rules()
    {
        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
        ];
    }

    protected function validationErrorMessages()
    {
        return [];
    }

    protected function validateEmail(Request $request)
    {
        $this->validate($request, ['email' => 'required|email']);
    }

    public function broker()
    {
        return Password::broker();
    }



}
