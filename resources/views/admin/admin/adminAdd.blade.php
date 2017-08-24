@extends('admin.common.base')
@section('css')
<link rel="stylesheet" href="{{ asset('admin/mycss/common/alertwords.css') }}" />
<link rel="stylesheet" href="{{ asset('admin/mycss/admin/add.css') }}" />
<link rel="stylesheet" href="{{ asset('admin/mycss/test.css') }}" />
@endsection
@section('first_title','权限管理')
@section('second_title','管理员添加')
@section('content')
<div class="page-header">
	<div id="info">
		@if(session('info'))
		<div class="callout callout-success">
			<p>{{session('info')}}</p>
		</div>
		@endif
	</div>
	<h1>
		<small>
			<a href="javascript:"onclick="self.location=document.referrer;">
				<button class="btn btn-xs return btn-info" id="return" >
          <!-- <i class="ace-icon fa fa-arrow-left icon-on-left"> -->
            返回
          </button>
        </a>
		</small>
	</h1>
</div><!-- /.page-header -->
<div class="row">
	<div class="col-xs-12">
		<!-- PAGE CONTENT BEGINS -->
		<form class="form-horizontal"  action="{{ url('admin/admin/insert') }}" method="post" >
			{{ csrf_field() }}
			<!-- <div class="form-group">
			<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 管理员账号 </label>
			<div class="col-sm-9">
			<input type="text" id="form-field-1" placeholder="ID" class="col-xs-10 col-sm-5"  />
		</div>
	</div> -->
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 管理员姓名 </label>
		<div class="col-sm-9">
			<input type="text" id="adname" maxlength="20" placeholder="输入管理员姓名（不能超过20字符）" class="col-xs-10 col-sm-5" name="name" value="" />
			<label class="  col-sm-3 control-label no-padding-right" ></label>
			<div class="col-sm-9 setInfo">
				<p class="spa spa9"></p>
			</div>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right"  for="form-field-1"> 邮箱 </label>
		<div class="col-sm-9">
			<input type="email"  placeholder="邮箱" id="email"  maxlength="32" class="col-xs-10 col-sm-5" name="email" value=""/>
			<label class="  col-sm-3 control-label no-padding-right" ></label>
			<div class="col-sm-9 setInfo">
				<p class="spa spa5"></p>
			</div>
		</div>
	</div>
	<div class="space-4"></div>
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 密码 </label>
		<div class="col-sm-9">
			<input type="password" placeholder="密码" id="password"  maxlength="20" class="col-xs-10 col-sm-5" name="password" value="" />
			<label class="  col-sm-3 control-label no-padding-right" ></label>
			<div class="col-sm-9 setInfo">
				<p class="spa spa10"></p>
			</div>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 请选择组</label>
		<div class="col-sm-9">
			<select name="group_id" id="sec">
				@foreach($data as $v)
					<option value="{{ $v -> id }}">{{ $v -> name }}</option>
				@endforeach
			</select>
		</div>
	</div>
	{{--<div class="form-group">--}}
		{{--<label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 电话 </label>--}}
		{{--<div class="col-sm-9">--}}
			{{--<input type="text" id="form-field-2" placeholder="电话" class="col-xs-10 col-sm-5" name="phone" value="" />--}}
			{{--</div>--}}
			{{--</div>--}}
			<div class="space-4"></div>
			<div class="clearfix form-actions" >
				<div class="col-md-offset-4 col-md-9">
					<button class="btn btn-info" type="submit" id="asub">
						<i class="icon-ok bigger-110"></i>
						添加
					</button>
					&nbsp; &nbsp; &nbsp;
					<button class="btn" type="reset">
						<i class="icon-undo bigger-110"></i>
						取消
					</button>
				</div>
			</div>
		</form>
	</div>
</div>
@endsection
@section('js')
<script src="{{ asset('admin/components/jquery/dist/jquery.js') }}"></script>
<script src="{{ asset('admin/components/jquery.1x/dist/jquery.js') }}"></script>
<script src="{{ asset('admin/myjs/test.js') }}"></script>

@endsection
