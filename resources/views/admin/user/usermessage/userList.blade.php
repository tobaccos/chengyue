@extends('admin.common.base')
@section('css')
<link rel="stylesheet" href="{{ asset('admin/mycss/common/alertwords.css') }}" />
<link rel="stylesheet" href="{{asset('admin/components/tablesorter/themes/blue/style.css') }}" />
<link rel="stylesheet" href="{{ asset('admin/mycss/user/list.css') }}" />
@endsection
@section('first_title','用户管理')
@section('second_title','用户列表')
@section('content')
<div class="col-xs-8 col-sm-11 data hidden-480" >
	<form action="{{ url('admin/user/usermessage/userList') }}" method="get">
		<div class="register">
			<span>注册时间:</span></div>
			<div class="input-daterange input-group">
				<input type="text" class="input-sm form-control" editable="false" placeholder="注册时间搜索" name="start" />
				<span class="input-group-addon">
					<i class="fa fa-exchange"></i>
				</span>
				<input type="text" class="input-sm form-control" placeholder="注册时间搜索" name="end" />
			</div>
			<!-- /section:plugins/date-time.datepicker -->
		</div>
		<div class="nav-search totop" id="nav-search">
			<form class="form-search">
				<span class="input-icon">
					<input type="text" placeholder="请输入用户名" maxlength="10" name="keywords" class="nav-search-input" id="nav-search-input" autocomplete="off" />
					<i class="ace-icon fa fa-search nav-search-icon"></i>
				</span>
				<button type="submit" class="btn btn-xs btn-info searchbtn">搜索<tton>
				</form>
			</div>
			<div class="row">
				<div class="col-xs-12">
					<!-- PAGE CONTENT BEGINS -->
					<div class="row">
						<div class="col-xs-12">
							<table id="simple-table" class="table  table-bordered table-hover dataTable tablesorter">
								<thead>
									<tr>
										<th >用户ID</th>
										<th>昵称</th>
										<th>用户类型</th>
										<th >消费总金额</th>
										<th class="hidden-480">邮箱</th>
										<!-- <th class="hidden-480">名称</th> -->
										<th class="hidden-480">
											手机号
										</th>
										<th class=" hidden-480">
											<i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i>
											创建时间
										</th>
										<th class="hidden-480">状态</th>
										<th >操作</th>
									</tr>
								</thead>
								<tbody>
									@foreach($data as $v)
									<tr>
										<td>{{$v -> id}}</td>
										<td>{{$v -> name}}</td>
										<td>{{$v -> tname}}</td>
										<td>{{$v -> pay_amount}}</td>
			  				    <td class="hidden-480">{{$v -> email}}</td>
									  <td class="hidden-480">{{$v -> phone}}</td>
								    <td class="hidden-480">{{$v -> created_at}}</td>
										<td class="hidden-480">
											@if($v -> state != 0)
											<span class="label label-sm label-warning">禁用</span>
											@else
											<span class="label label-sm label-success">启用</span>
											@endif
										</td>
										<td>
											<div class="hidden-sm hidden-xs ">
												@if($v -> state != 0)
												<a href="{{ url('admin/user/usermessage/state')}}/{{$v -> id}}"><button class="btn btn-xs btn-success">启用</button></a>
												@else
												<a href="{{ url('admin/user/usermessage/state')}}/{{$v -> id}}"><button class="btn btn-xs btn-warning" >禁用</button></a>
												@endif
												<a href="{{ url('admin/user/usermessage/userDetail') }}/{{$v -> id}}"><input type="button"  class="btn btn-xs " value="查看详情"/> </a>
												<a href="{{ url('admin/user/usermessage/userChange') }}/{{$v -> id}}"><input type="button" id="man_del" class="btn btn-xs btn-info" value="修改"/> </a>
												<button class="btn btn-xs btn-success " onclick="return resid({{ $v -> id }})">重置密码 </button>
												<button class="btn btn-xs btn-danger del" onclick="return getid({{ $v -> id }}) ">删除 </button>
											</div>
											<div class="hidden-md hidden-lg">
												<div class="inline pos-rel">
													<button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown" data-position="auto">
														<i class="ace-icon fa fa-cog icon-only bigger-110"></i>
													</button>
													<ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
														<li>
															<a href="{{ url('admin/user/usermessage/userDetail') }}/{{$v -> id}}" class="tooltip-info" data-rel="tooltip" title="View">
																<span class="blue">
																	<i class="ace-icon fa fa-search-plus bigger-120"></i>
																</span>
															</a>
														</li>
														<li>
															<a href="{{ url('admin/user/usermessage/userChange') }}/{{$v -> id}}" class="tooltip-success" data-rel="tooltip" title="Edit">
																<span class="green">
																	<i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
																</span>
															</a>
														</li>
														<li>
															<a href="{{ url('admin/user/usermessage/delete') }}/{{$v -> id}} }}" class="tooltip-error" data-rel="tooltip" title="Delete">
																<span class="red">
																	<i class="ace-icon fa fa-trash-o bigger-120"></i>
																</span>
															</a>
														</li>
													</ul>
												</div>
											</div>
										</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
					<div style="text-align:center">
						{{ $data -> appends($request) -> links() }}
					</div>
				</div>
			</div>
			@endsection
			@section('js')
<script src="{{ asset('admin/components/jquery/dist/jquery.js') }}"></script>
<script src="{{ asset('admin/components/jquery.1x/dist/jquery.js') }}"></script>
<script src="{{ asset('admin/components/_mod/jquery-ui.custom/jquery-ui.custom.js') }}"></script>
<script src="{{ asset('admin/components/jqueryui-touch-punch/jquery.ui.touch-punch.js') }}"></script>
<script src="{{ asset('admin/components/chosen/chosen.jquery.js') }}"></script>
<script src="{{ asset('admin/components/fuelux/js/spinbox.js') }}"></script>
<script src="{{ asset('admin/components/bootstrap-datepicker/dist/js/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('admin/components/bootstrap-timepicker/js/bootstrap-timepicker.js') }}"></script>
<script src="{{ asset('admin/components/moment/moment.js') }}"></script>
<script src="{{ asset('admin/components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('admin/components/eonasdan-bootstrap-datetimepicker/src/js/bootstrap-datetimepicker.js') }}"></script>
<script src="{{ asset('admin/components/mjolnic-bootstrap-colorpicker/dist/js/bootstrap-colorpicker.js') }}"></script>
<script src="{{ asset('admin/components/jquery-knob/js/jquery.knob.js') }}"></script>
<script src="{{ asset('admin/components/autosize/dist/autosize.js') }}"></script>
<script src="{{ asset('admin/components/jquery-inputlimiter/jquery.inputlimiter.js') }}"></script>
<script src="{{ asset('admin/components/jquery.maskedinput/dist/jquery.maskedinput.js') }}"></script>
<script src="{{ asset('admin/assets/js/src/ace.js') }}"></script>
<script src="{{ asset('admin/assets/js/src/elements.fileinput.js') }}"></script>
<script src="{{ asset('admin/assets/js/src/elements.spinner.js') }}"></script>
<script src="{{ asset('admin/components/_mod/bootstrap-tag/bootstrap-tag.js') }}"></script>

<script type="text/javascript">
    //checkbox 全选/取消全选
    var isCheckAll = false;
    var delUrl="{{ url('admin/user/usermessage/delete') }}";
    var libid="{{ url('admin/user/usermessage/delete') }}";
		var resUrl="{{ url('admin/user/resetPass') }}";
</script>
{{--页面摘出--}}
<script src="{{ asset('admin/myjs/user/list.js') }}"></script>
<script src="{{ asset('admin/components/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('admin/components/tablesorter/jquery.tablesorter.min.js') }}"></script>
<script type="text/javascript">
  $(document).ready(function() {
 	 $("#simple-table").tablesorter({
 		 headers:{
 			 0:{sorter:false},
 			 1:{sorter:false},
 			 2:{sorter:false},
 			 5:{sorter:false},

 			 7:{sorter:false},
 			 8:{sorter:false},
 			 9:{sorter:false}
 		 }
 	 });
 });
</script>
@endsection
