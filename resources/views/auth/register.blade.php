@extends('layouts.app')
@section('title')
    注册
@endsection
@section('content')
    <link href="{{ asset('css/home/loginres/register.css') }}" rel="stylesheet">
    <div class="header">
        <span><a href="{{url('login/')}}"><img class="imgleft" src="{{url('images/base/back.png')}}"></a></span>
        <span class="left">注册</span>
    </div>
    <!--中间图-->
    <div class="banner">
        <img src="{{ asset('images/login/loginlogo.png')}}" alt="" />
    </div>
    <div class="common">
        <div class="chose">
            邮箱/手机注册
        </div>
        <!--邮箱注册-->
        <div id="emailreg">
            <div id="phone">
                <form class="form-horizontal"  onsubmit="delay()" role="form" method="POST" action="{{ route('register') }}">
                    {{ csrf_field() }}
                    <div class="group{{ $errors->has('name') ? ' has-error' : '' }}">
                        @if(isset($_GET['par']))
                            <input type="hidden" name="father_id" value="{{$_GET['par']}}">
                        @endif
                        
                        <input type="text" placeholder="请输入用户名" id="name" class="form-control" name="name" value="{{ old('name') }}"  autofocus maxlength="20">
                        <img src="{{ asset('images/login/user.png')}}" alt="" / >
                        @if ($errors->has('name'))
                            <span class="help-block">
                           <strong class="uNotice">{{ $errors->first('name') }}</strong>
                        </span>
                            @else
                                <span class="help-block">
                           <strong class="uNotice"></strong>
                        </span>
                        @endif
                    </div>
                    <div class="group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <input type="text" placeholder="请输入邮箱/手机号" id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" >
                        <img src="{{ asset('images/login/info.png')}}" alt="" / >
                        @if ($errors->has('email'))
                            <span class="help-block">
                              <strong class="eNotice">{{ $errors->first('email') }}</strong>
                            </span>
                        @else
                            <span class="help-block">
                              <strong class="eNotice"></strong>
                            </span>
                        @endif
                         @if ($errors->has('phone'))
                            <span class="help-block">
                              <strong class="eNotice">{{ $errors->first('phone') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <input type="password" placeholder="请输入密码" id="password" type="password" class="form-control" name="password" maxlength="20">
                        <img src="{{ asset('images/login/mima2.png')}}" alt="" />
                        @if ($errors->has('password'))
                            <span class="help-block">
                                        <strong class="pNotice">{{ $errors->first('password') }}</strong>
                                    </span>
                            @else
                            <span class="help-block">
                                        <strong class="pNotice"></strong>
                                    </span>
                        @endif
                    </div>
                    <div class="group">
                        <input class="" placeholder="请确认密码" id="password-confirm" type="password" class="form-control" name="password_confirmation" maxlength="20">
                        <span class="help-block">
                                <strong class="repNotice"></strong>
                         </span>
                        <img src="{{ asset('images/login/mima2.png')}}" alt="" />
                    </div>
                    <div class="group">
                        <button type="submit" class="regBtn disabled" >注册</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script src="{{ asset('js/jquery-3.0.0.min.js') }}"></script>
    <script src="{{ asset('js/home/loginres/register.js') }}"></script>
@endsection
