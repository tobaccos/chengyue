@extends('layouts.app')
@section('title')
登录
@endsection
@section('content')
<!--登录页-->
<link href="{{ asset('css/home/loginres/login.css') }}" rel="stylesheet">
<div class="header">
	<a class="left" href="{{ url('/')}}">首页</a>
	<span class="right"> <a href="{{route('register')}}">免费注册</a></span>
</div>
<!--中间图-->	
<div class="banner">
	<img src="{{ asset('images/login/loginlogo.png')}}" alt="" />
	<h6>账号密码登录</h6>
</div>
    <div class="common">
    	 <form  method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

             <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} userword">
             <span  class="users">账号</span>
             <span class="logindel"><img src="{{ asset('images/login/logindel.png')}}" alt="" /></span>
             <div class="">
             	@if(empty(old('email')))
             		<input id="email" type="text" placeholder="请输入邮箱或手机号码" class="form-control" name="email" value="{{ old('phone') }}" maxlength="20" autofocus>
             	@else
             	
                <input id="email" type="text" placeholder="请输入邮箱或手机号码" class="form-control" name="email" value="{{ old('email') }}" maxlength="20" autofocus>
                 @endif
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                 @if ($errors->has('phone'))
                     <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                 @endif
                </div>
             </div>
                   <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} userword">
                        <span for="password" class="control-label users">密码</span>
                        <span class="worddel"><img src="{{ asset('images/login/logindel.png')}}" alt="" /></span>
                        <span class="open"><img src="{{ asset('images/login/open.png')}}" alt="" / ></span>
                        <span class="close"><img src="{{ asset('images/login/close.png')}}" alt="" / ></span>
                        <div class="col-md-6">
                         <input id="password" type="password" class="form-control" name="password" placeholder="请输入密码" maxlength="20">
                            @if ($errors->has('password'))
                                <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                @endif
                        </div>
                    </div>

             @if(isset($_COOKIE['limit']))
                 <div >
                     <input type="text" name="captcha" class="checkone" maxlength="5" >
                     <a onclick="javascript:re_captcha();" ><img src="{{ URL('kit/captcha/1') }}" class="pica" alt="验证码" title="刷新图片" id="c2c98f0de5a04167a9e427d883690ff6" ></a>
                     @if(session('info'))
                         <div class="errorz">
                             <p>{{session('info')}}</p>
                         </div>
                     @endif
                 </div>
             @endif
                        <div class="form-group">
                                <div class="checkbox userword">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }} class="remember"> 记住密码
                                    </label>
                                </div>                          
                        </div>

                        <div class="group">
                            <div class="">
                                <button type="submit" class="loginb disabled">
                                    	登录
                                </button>           
                            </div>
                            <a class="forget" href="{{ route('password.request') }}">
                                                                忘记密码
                            </a>
                        </div>
            </form>
    </div>
    <script>
        function re_captcha() {
            $url = "{{ URL('kit/captcha') }}";
            $url = $url + "/" + Math.random();
            document.getElementById('c2c98f0de5a04167a9e427d883690ff6').src=$url;
        }
    </script>
     <script src="{{ asset('js/jquery-3.0.0.min.js') }}"></script>
    <script src="{{ asset('js/home/loginres/login.js') }}"></script>
@endsection

