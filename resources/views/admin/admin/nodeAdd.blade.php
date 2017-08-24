@extends('admin.common.base')
@section('css')
<link rel="stylesheet" href="{{ asset('admin/mycss/common/alertwords.css') }}" />
<link rel="stylesheet" href="{{ asset('admin/mycss/admin/nodeAdd.css') }}" />
<link rel="stylesheet" href="{{ asset('admin/mycss/test.css') }}" />

@endsection
@section('first_title','权限管理')
@section('second_title','节点添加')
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
				<button class="btn btn-xs return btn-info" id="return">
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
		<form class="form-horizontal"  action="{{ url('admin/admin/nodeAdd') }}" method="post" >
			{{ csrf_field() }}
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-1">规则名称</label>
		<div class="col-sm-9">
			<select class="col-sm-5" name="father_id" id="select">
				@foreach($data as $v)
					<option value="{{ $v -> id }}">{{ $v -> name }}</option>
				@endforeach
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-1">规则标题</label>
		<div class="col-sm-9">
			<input type="text" id="nodename" placeholder="输入标题"  maxlength="20" class="col-xs-10 col-sm-5" name="name" value=""/>
			<label class="col-sm-3 control-label no-padding-right" ></label>
			<div class="col-sm-9 setInfo">
				<p class="spa spa11"></p>
			</div>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-1">规则路径</label>
		<div class="col-sm-9">
			<input type="text" id="lujing"  placeholder="输入规则路径"  maxlength="40" class="col-xs-10 col-sm-5" name="url" value=""/>
			<label class="col-sm-3 control-label no-padding-right" ></label>
			<div class="col-sm-9 setInfo">
				<p class="spa spa12"></p>
			</div>
		</div>
	</div>
			<div class="space-4"></div>
			<div class="clearfix form-actions" >
				<div class="col-md-offset-4 col-md-9">
					<button class="btn btn-info" type="submit" id="nsub">
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
<!-- <script>
$(document).ready(function(){//页面加载完之后，自动执行该方法
    setTimeout(function(){$("#info").hide();},2000);//2秒后执行该方法
});
</script> -->
@endsection
