@extends('admin.common.base')
@section('css')
<link rel="stylesheet" href="{{ asset('admin/mycss/common/alertwords.css') }}" />
<link rel="stylesheet" href="{{ asset('admin/mycss/user/userDetail.css') }}" />
@endsection
@section('first_title','用户管理')
@section('second_title','用户详情')
@section('content')
<div class="page-header">
	<h1>
		用户详情
		<a href="javascript:" onclick="self.location=document.referrer;">
			<button class="btn btn-xs return btn-info" style="float:right">
				返回
			</button>
		</a>
	</h1>
</div>
<div class="col-xs-12">
	<form class="form-horizontal" role="form">
		@foreach($users as $k => $v)
		<div class="form-group">
			<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 用户昵称 </label>
			<div class="col-sm-9" >
				<input type="text" placeholder="昵称" class="col-xs-7 col-sm-5" disabled="disabled" value="{{ $v -> name }}" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 用户状态 </label>
			<div class="col-sm-9">
				<div class="radio">
					<label>
						<input name="form-field-radio" type="radio" class="ace" @if($v -> state == 0) checked @endif />
						<span class="lbl">启用</span>
					</label>
					<label>
						<input name="form-field-radio" type="radio" class="ace" @if($v -> state == 1) checked @endif />
						<span class="lbl">禁用</span>
					</label>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 用户类型 </label>
			<div class="col-sm-9">
				<input type="text" placeholder="用户类型" class="col-xs-7 col-sm-5"  disabled="disabled" value="{{ $v -> tname }}" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 账户余额 </label>
			<div class="col-sm-9">
				<input type="text" placeholder="账户余额" class="col-xs-7 col-sm-5"  disabled="disabled" value="{{ $v -> virtualcurrency }}" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 邮箱 </label>
			<div class="col-sm-9">
				<input type="email" placeholder="邮箱" class="col-xs-7 col-sm-5"  disabled="disabled" value="{{$v -> email}}" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 control-label no-padding-right" for="form-field-2"> QQ </label>
			<div class="col-sm-9">
				<input type="text" placeholder="QQ" class="col-xs-7 col-sm-5"  disabled="disabled" value="{{$v -> QQ}}" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 电话 </label>
			<div class="col-sm-9">
				<input type="text" placeholder="电话" class="col-xs-7 col-sm-5"   disabled="disabled" value="{{$v -> phone}}" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 创建时间 </label>
			<div class="col-sm-9">
				<input type="text" placeholder="创建时间" class="col-xs-7 col-sm-5"disabled="disabled" value="{{ $v -> created_at }}" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 是否为代理商 </label>
			<div class="col-sm-9">
				<input type="text" placeholder="代理商申请状态" class="col-xs-7 col-sm-5" disabled="disabled" value="@if($v -> dls_apply == 2) 是 @else 否 @endif"/>
			</div>
		</div>
		<div style="text-align:center ; margin-bottom:20px" >
			<button type="button" class="btn btn-success btn-sm"id="nidd" >显示/隐藏分销详情</button>
			<label class=" " for=""> 推广总人数：{{ $num }}</label>
		</div>
	</div>
</form>
@endforeach
<div class="row">
	<div class="col-xs-12">
		<table class="table table-bordered table-hover" id="tab" style="display:none;">
			<tbody>
				<tr class="info">
					<td>用户ID </td>
					<td>用户昵称</td>
					<td>创建时间</td>
					<td>用户类型</td>
					<td>订单数量</td>
					<td>消费总金额</td>
					<td>操作</td>
				</tr>
				@foreach($data as $v)
				<tr>
					<td>{{$v -> id}} </td>
					<td>{{$v -> username}} </td>
					<td>{{$v -> created_at}} </td>
					<td>{{$v -> tname}} </td>
					<td>{{$v -> count}} </td>
					<td>{{$v -> pay_amount}} </td>
					<td>
						<button type="button" class="btn btn-xs btn-success cha1" data-toggle="modal" data-target=".bs-example-modal-sm">查看订单详情
						</button>
					</td>
				</tr>
			</tbody>
		</table>
			@endforeach
		<!-- 模态框 -->
		<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
			<div class="modal-dialog " style="width:500px" >
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<h4 class="modal-title">订单详情</h4>
					</div>
					<div class="modal-body"style=" font-size:16px">
						@foreach($data as $v)
						@foreach($v ->pname as $value)
						<div style="border:solid 1px #66ccff; margin-bottom:10px ">
							<p>商品名称：{{ $value -> name}}</p>
							<p>订单产生时间：{{ $value -> addtime}}</p>
							<p>订单金额：{{ $value -> pay_amount}}</p>
						</div>
						@endforeach
						@endforeach
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('js')
<script src="{{ asset('admin/components/jquery/dist/jquery.js') }}"></script>
<script src="{{ asset('admin/components/jquery.1x/dist/jquery.js') }}"></script>
<script src="{{ asset('admin/myjs/user/userDetail.js') }}"></script>
<script type="text/javascript">
// var cha1Url="{{ url('admin/user/application/show') }}";
	</script>
@endsection
