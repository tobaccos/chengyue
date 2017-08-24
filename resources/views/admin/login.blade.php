<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta charset="utf-8" />
	<title>Login Page - Ace Admin</title>
	<meta name="description" content="User login page" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
	<link rel="stylesheet" href="{{ asset('admin/assets/css/bootstrap.css') }}" />
	<link rel="stylesheet" href="{{ asset('admin/components/font-awesome/css/font-awesome.css') }}"/>
	<link rel="stylesheet" href="{{ asset('admin/assets/css/ace-fonts.css') }}" />
	<link rel="stylesheet" href="{{ asset('admin/assets/css/ace.css') }}" />
	<link rel="stylesheet" href="{{ asset('admin/assets/css/ace-rtl.css') }}" />
	<link rel="stylesheet" href="{{ asset('admin/mycss/login.css') }}" />
</head>
<body class="login-layout" >
	<div id="div1"><img src="{{url('admin/images/login.png')}}" /></div>
		<div class="main-container">
			<div class="main-content">
				<div class="row">
					<div class="col-sm-10 col-sm-offset-1">
						<div class="login-container" style="margin-top:120px">
							<div class="center">
								<div id="info">
									@if(session('info'))
									<div class="callout callout-success">
										<p id="sess">{{session('info')}}</p>
									</div>
									@endif
								</div>
								<h1>
									<img src="{{ url('admin/images/logo.png') }}" style="width:38px;">
									<span class="red">印汇商盟</span>
									<span class="grey" id="id-text2">后台管理系统</span>
								</h1>
								<h4 class="blue" id="id-company-text">&copy; www.yinhuishangmeng.com</h4>
							</div>
							<div class="space-6">
							</div>
							<div class="position-relative">
								<div id="login-box" class="login-box visible  no-border login11" >
									<div class="widget-body">
										<div class="widget-main">
											<h4 class="header blue lighter bigger" style="text-align:center">
												后台登录系统
											</h4>
											<div class="space-6"></div>
											<form method="post" action="{{ url('admin/login')}}">
												{{ csrf_field() }}
												<fieldset>
													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="text" class="form-control" placeholder="Username" name="name" value="{{ old('name') }}" />
															<i class="ace-icon fa fa-user"></i>
														</span>
													</label>
													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="password" class="form-control" placeholder="Password" name="password" value="{{ old('password') }}"/>
															<i class="ace-icon fa fa-lock"></i>
														</span>
													</label>
													<div class="space">
													</div>
													{{--验证码--}}
													<div >
				                     <input type="text" name="captcha" class="checkone" >
				                     <a onclick="javascript:re_captcha();" ><img src="{{ URL('kit/captcha/1') }}" class="pica" alt="验证码" title="刷新图片" id="c2c98f0de5a04167a9e427d883690ff6" ></a>
				                 </div>

													<div class="clearfix">
														<button type="submit" class="width-35 pull-right btn btn-sm btn-primary dee">
															<i class="ace-icon fa fa-key"></i>
															<span class="bigger-110">登录</span>
														</button>
													</div>
													<div class="space-4">
													</div>
												</fieldset>
											</form>
											<div class="space-6"></div>
										</div>
									</div>
								</div>
								<div id="forgot-box" class="forgot-box widget-box no-border">
									<div class="widget-body">
										<div class="widget-main">
											<h4 class="header red lighter bigger">
												<i class="ace-icon fa fa-key"></i>
												Retrieve Password
											</h4>
											<div class="space-6"></div>
											<p>
												Enter your email and to receive instructions
											</p>
											<form>
												<fieldset>
													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="email" class="form-control" placeholder="Email" />
															<i class="ace-icon fa fa-envelope"></i>
														</span>
													</label>
													<div class="clearfix">
														<button type="button" class="width-35 pull-right btn btn-sm btn-danger">
															<i class="ace-icon fa fa-lightbulb-o"></i>
															<span class="bigger-110">Send Me!</span>
														</button>
													</div>
												</fieldset>
											</form>
										</div><!-- /.widget-main -->
										<div class="toolbar center">
											<a href="#" data-target="#login-box" class="back-to-login-link">
												Back to login
												<i class="ace-icon fa fa-arrow-right"></i>
											</a>
										</div>
									</div><!-- /.widget-body -->
								</div><!-- /.forgot-box -->
								<div id="signup-box" class="signup-box widget-box no-border">
									<div class="widget-body">
										<div class="widget-main">
											<h4 class="header green lighter bigger">
												<i class="ace-icon fa fa-users blue"></i>
												新用户注册
											</h4>
											<div class="space-6"></div>
											<p> 请输入您的信息 </p>
											<form>
												<fieldset>
													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="email" class="form-control" placeholder="Email" />
															<i class="ace-icon fa fa-envelope"></i>
														</span>
													</label>
													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="text" class="form-control" placeholder="Username" />
															<i class="ace-icon fa fa-user"></i>
														</span>
													</label>
													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="password" class="form-control" placeholder="Password" />
															<i class="ace-icon fa fa-lock"></i>
														</span>
													</label>
													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="password" class="form-control" placeholder="Repeat password" />
															<i class="ace-icon fa fa-retweet"></i>
														</span>
													</label>
													<label class="block">
														<input type="checkbox" class="ace" />
														<span class="lbl">
															阅读并接受
															<a href="#">用户使用协议</a>
														</span>
													</label>
													<div class="space-24"></div>
													<div class="clearfix">
														<button type="reset" class="width-30 pull-left btn btn-sm">
															<i class="ace-icon fa fa-refresh"></i>
															<span class="bigger-110">清空</span>
														</button>
														<button type="button" class="width-65 pull-right btn btn-sm btn-success">
															<span class="bigger-110">注册</span>
															<i class="ace-icon fa fa-arrow-right icon-on-right"></i>
														</button>
													</div>
												</fieldset>
											</form>
										</div>
										<div class="toolbar center">
											<a href="#" data-target="#login-box" class="back-to-login-link">
												<i class="ace-icon fa fa-arrow-left"></i>
												返回登录
											</a>
										</div>
									</div><!-- /.widget-body -->
								</div><!-- /.signup-box -->
						</div>
					</div>
				</div>
			</div>
		</div>
		<script>
        function re_captcha() {
            $url = "{{ URL('kit/captcha') }}";
            $url = $url + "/" + Math.random();
            document.getElementById('c2c98f0de5a04167a9e427d883690ff6').src=$url;
        }
    </script>
		<script src="{{ asset('admin/components/jquery/dist/jquery.js') }}"></script>
		<script type="text/javascript">
    if('ontouchstart' in document.documentElement) document.write("<script src='{{ asset("admin/components/_mod/jquery.mobile.custom/jquery.mobile.custom.js") }}'>"+"<"+"/script>");
		</script>
		<script src="{{ asset('admin/myjs/login.js') }}"></script>
	</body>
</html>
