@extends('admin.common.base')
@section('css')
<link rel="stylesheet" href="{{ asset('admin/mycss/common/alertwords.css') }}" />
<link rel="stylesheet" href="{{ asset('admin/mycss/admin/groups.css') }}" />
@endsection
@section('first_title','权限管理')
@section('second_title','分组管理')
@section('content')
<a href="{{ url('admin/admin/userGroup') }}">
	<button class="btn btn-xs btn-info mybtn">
		<i class="ace-icon fa fa-bolt bigger-110"></i>
		添加分组
		<i class="ace-icon fa fa-arrow-right icon-on-right"></i>
	</button>
</a>
<div class="row">
	<div class="col-xs-12">
		<!-- PAGE CONTENT BEGINS -->
		<div class="row">
			<div class="col-xs-12">
				<table id="simple-table" class="table  table-bordered table-hover " >
					<thead>
						<tr>
							<th>编号</th>
							<th>名称</th>
							<th>权限</th>
						</tr>
					</thead>
					<tbody>
					<tr>
						<th>1</th>
						<th>超级管理员</th>
						<th>默认拥有所有权限</th>
					</tr>
					@foreach($data as $v)
					@if($v->id >1)
					<tr id="select" >
						<td>{{ $v -> id }}</td>
						<td>{{ $v -> name }}</td>
						<td>
							<button class="btn btn-xs btn-grey cha"  data-toggle="modal" data-target=".bs-example-modal-sm" rel="{{ $v -> id }}" >查看权限</button>
							<a href="{{ url('admin/admin/groupChange') }}/{{ $v -> id}}"><button class="btn btn-xs btn-info " >修改</button></a>
							<button class="btn btn-xs btn-danger del" onclick="return getid({{ $v -> id }}) ">删除 </button>
						</td>
					</tr>
					@endif
					@endforeach
				</tbody>
			</table>
			<!-- 模态框 -->
			<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="Modal">
				<div class="modal-dialog mod2" >
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
							<h4 class="modal-title">权限详情</h4>
						</div>
						<div class="modal-body" id="modd" >
							<!-- <textarea style="width:100%" rows="7" name="content" value="" id="tee" disabled></textarea> -->
						</div>
					</div>
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
<script src="{{ asset('admin/myjs/admin/groups.js') }}"></script>
<script type="text/javascript">
var isCheckAll = false;
var showUrl="{{ url('admin/admin/show') }}";
var delUrl="{{ url('admin/admin/groupDel') }}";
</script>
@endsection
