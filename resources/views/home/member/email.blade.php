@extends('layouts.app')
@section('title')
邮箱找回密码
@endsection
@section('content')
<link href="{{ asset('css/home/loginres/email.css') }}" rel="stylesheet">
<div class="header">
	<span><a href="{{url('login/')}}"><img class="imgleft" src="{{url('images/base/back.png')}}"></a></span>
	<span class="left">找回支付密码</span>	
</div>
<!--中间图-->	
<div class="banner">
	<img src="{{ asset('images/login/loginlogo.png')}}" alt="" />
	<h6>找回支付密码</h6>
</div>
<div id="reset">
	@if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
 		 <form  class="form-horizontal" role="form" method="POST" action="{{ url('reset') }}">
                        {{ csrf_field() }}

            <div class="group{{ $errors->has('email') ? ' has-error' : '' }}">
            	<input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}"  placeholder="请输入邮箱地址">
            	<span style="font-size: 0.51rem;">邮箱地址</span>
            </div>
            
            	  @if ($errors->has('email'))
                     <span class="help-block">
                        <strong style="font-size:0.4rem;">{{ $errors->first('email') }}</strong>
                   </span>
                 @endif
            <div class="group">
            	<button type="submit">发送邮箱链接</button>
            </div>
        </form>
 	</div>

@endsection
