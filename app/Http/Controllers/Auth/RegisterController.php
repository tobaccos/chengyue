<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Controllers\Auth\Input;
use DB;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers ;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $data = $this->is_email($data);
        return Validator::make($data, [
            'name'      => 'sometimes|required|string|min:6|max:15',
            'email'     => 'sometimes|required|string|email|max:255|unique:users',
            'phone'     => 'sometimes|required|regex:/^1[34578][0-9]{9}$/|unique:users',
            'password'  => 'required|string|min:6|max:20|confirmed',
        ],[
            'name.required'        =>   '用户名不能为空！',
            'name.min'             =>   '用户名不能低于6位',
            'name.max'             =>   '用户名超过限制长度',
            'email.required'       =>   '邮箱不能为空！',
            'email.email'          =>   '邮箱格式不正确！',
            'email.unique'         =>   '该邮箱已注册',
            'password.required'    =>   '密码不能为空',
            'password.min'         =>   '密码长度最少6位',
            'password.max'         =>   '密码最大长度20位',
            'password.confirmed'   =>   '确认密码不一致',
            'phone.required'       =>   '手机号码不能为空',
            'phone.regex'          =>   '手机号码格式不正确',
            'phone.unique'         =>   '手机已注册',

        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {

        $father_id = isset($data['father_id'])? $data['father_id'] : 0;
        if($father_id != 0){
            $res = DB::table('user_info')
                ->where([
                    ['user_id',$father_id],
                    ['dls_apply',2]
                ])
                ->first();
            if(!$res){
                $father_id = 0;
            }
        }
        $data = $this->is_email($data);

        if(isset($data['phone']))
        {
            return User::create([
                'phone'     => $data['phone'],
                'name'      => $data['name'],
                'father_id' => $father_id,
                'password'  => bcrypt($data['password']),
            ]);
        }else{
            return User::create([
                'name'      => $data['name'],
                'email'     => $data['email'],
                'father_id' => $father_id,
                'password'  => bcrypt($data['password']),
            ]);

        }

    }

    /**
     *  验证是email OR phone
     * @param $data
     * @return mixed
     */
    protected function is_email($data)
    {
        $field = filter_var($data['email'], FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';
        $data[$field] = $data['email'];
        if($field == 'phone'){
            unset($data['email']);
        }
        return $data;
    }


}
