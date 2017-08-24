@extends('admin.common.base')
@section('css')
	<link rel="stylesheet" href="{{ asset('admin/mycss/common/alertwords.css') }}" />
	<link rel="stylesheet" href="{{ asset('admin/mycss/admin/userGroup.css') }}" />
	<link rel="stylesheet" href="{{ asset('admin/mycss/test.css') }}" />
	<meta name="csrf-token" content="{{ csrf_token() }}">

@endsection
@section('first_title','权限管理')
@section('second_title','添加分组')
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
			<div class="page-header">
				<h1>添加分组</h1>
			</div>
			<form action="{{ url('admin/admin/groupAdd') }}" method="post" class="k">
				{{ csrf_field() }}
				<div class="input2">
					<label for="title">分组名称</label>
					<input type="text" maxlength="20" name="title" class="form-control input1" id="title" placeholder="请输入分组名称，长度应为2到20个字符">
					<label class="  col-sm-3 control-label no-padding-right" ></label>
          <div class="col-sm-9 setInfo">
            <p class="spa spa17"></p>
          </div>

				</div>
				<br>
				<label for="node">权限</label>
				<div class="input2">
					@foreach($data as $v)
						<div id="classify" >
							@if($v -> father_id == 0)
								<div >
									<div class="inn" id="inn" >
										<h4 >{{ $v->name }}</h4>
										<button type="button" class="btn btn-xs btn-info checkAll">全选</button>
										<div>
											@foreach($res as $value)
												@if($value-> father_id == $v -> id)
													<div id="admin" class="inn checkStyle"><input type="checkbox" name="id" value="{{ $value -> id }}"/>{{ $value -> name }}</div>
												@endif
											@endforeach
										</div>
									</div>
									</br>
								</div>
							@endif
						</div>
					@endforeach
				</div>
				<div style="margin-top:30px">
					<input type="button" id="gsub" class="btn btn-primary" value="提交">
				</div>
			</form>
		</div>
	</div>
@endsection
@section('js')
<script src="{{ asset('admin/components/jquery/dist/jquery.js') }}"></script>
<script src="{{ asset('admin/components/jquery.1x/dist/jquery.js') }}"></script>
<script src="{{ asset('admin/myjs/admin/userGroup.js') }}"></script>
<script src="{{ asset('admin/myjs/test.js') }}"></script>
<script>
var chec = true;
var che2Url= "{{ url('admin/admin/groupAdd') }}";
</script>
@endsection
