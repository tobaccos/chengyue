@extends('admin.common.base')
@section('css')
<link rel="stylesheet" href="{{ asset('admin/mycss/common/alertwords.css') }}" />
<link rel="stylesheet" href="{{asset('admin/components/tablesorter/themes/blue/style.css') }}" />
<link rel="stylesheet" href="{{ asset('admin/mycss/order/list.css') }}" />
<!-- <link rel="stylesheet" href="{{ asset('admin/mycss/order/logistic.css') }}" /> -->

@endsection
@section('first_title','订单管理')
@section('second_title','已发货订单')
@section('content')
		<button class="btn  btn-xs btn-danger mybtn"  id="del">
			<i class="ace-icon fa fa-bolt bigger-110"></i>
			批量删除
			<i class="ace-icon fa fa-trash-o icon-only icon-on-right"></i>
		</button>
		<form action="{{ url('admin/order/orderDetails') }}" method="post">
		{{ csrf_field() }}
			<input type="hidden" name="ids" value="" id="ids">
			<button class="btn  btn-xs btn-info mybtn1" type="submit" id="print" >
			<i class="ace-icon fa fa-bolt bigger-110"></i>
			批量打印
			<i class="ace-icon fa fa-arrow-right icon-on-right"></i>
		</button>

			<!-- <input type="submit" class="btn  btn-xs btn-info mybtn1" style="margin-left:10px" value="批量打印" id="print"> -->
		</form>
			<div class="col-xs-8 col-sm-11 data hidden-480" >
				<form class="form-search" action="{{ url('admin/order/orderDelivering') }}/3" method="get">
					<div class="input-daterange input-group">
						<input type="text" class="input-sm form-control"  placeholder="下单时间搜索" name="start" />
						<span class="input-group-addon">
							<i class="fa fa-exchange"></i>
						</span>
						<input type="text" class="input-sm form-control"  placeholder="下单时间搜索" name="end" />
					</div>
					<!-- /section:plugins/date-time.datepicker -->
				</div>
				<div class="nav-search totop" id="nav-search " >

						<span class="input-icon">
							<input type="text" placeholder="请输入订单号" class="nav-search-input" maxlength="25" id="nav-search-input" autocomplete="off" name="keyword" />
							<i class="ace-icon fa fa-search nav-search-icon"></i>
						</span>
						<button type="submit" class="btn btn-xs btn-info searchbtn">搜索</button>
					</form>
				</div>
	<div class="row">
		<div class="col-xs-12">
			<!-- PAGE CONTENT BEGINS -->
			<div class="row">
				<div class="col-xs-12">
					<table id="simple-table" class="table  table-bordered table-hover tablesorter">
						<thead>
							<tr>
								{{--<th class="center">--}}
									{{--<label class="pos-rel">--}}
										{{--<input type="checkbox" class="ace" onclick="swapCheck()"/>--}}
										{{--<span class="lbl"></span>--}}
									{{--</label>--}}
								{{--</th>--}}
								<th>
									<input type="checkbox" value=""   onclick="swapCheck()">&nbsp;全选</input>
								</th>
								<th>订单编号</th>
								<th>用户</th>
								<th class="hidden-480">商品</th>
								<th class="hidden-480">商品数量</th>
								<th>消费金额</th>
								<th class="hidden-480">
									<i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i>
									发货时间
								</th>
								<th >操作</th>
							</tr>
						</thead>
						<tbody>
						@foreach($data as $v)
							<tr>
								<td class="center">
									<label class="pos-rel">
										<input type="checkbox"  name="id" value="{{$v->id}}" />
										<span class="lbl"></span>
									</label>
								</td>
								<td>
									{{ $v -> order_sn }}
								</td>
								<td>
									{{ $v -> name }}
								</td>
								<td class="hidden-480">
									{{ $v -> pname }}
								</td>
								<td class="hidden-480">{{ $v -> pname }}</td>
								<td>{{ $v -> pay_amount }}</td>
								<td class="hidden-480">{{ $v -> shipping_time }}</td>
								<td>
									<div class="hidden-sm hidden-xs ">
										<a href="{{ url('admin/order/orderDetail') }}/{{ $v-> id }}"><input type="button" id="man_del" class="btn btn-xs btn-success" value="打印订单"/> </a>
										<a href="{{ url('admin/order/orderDetail') }}/{{$v -> id}}"><input type="button" id="man_del" class="btn btn-xs" value="查看详情"/> </a>
										<button class="btn btn-xs btn-danger del" onclick="return getid({{ $v -> id }}) ">删除 </button>
										@if( $v -> demand1 || $v -> demand2)
											<a class="btn btn-xs btn-info" href="{{ url('admin/order/orderUpload') }}/{{ $v -> id }}">查看文件</a>
										@endif
										<div class="hidden-md hidden-lg">
											<div class="inline pos-rel">
												<button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown" data-position="auto">
													<i class="ace-icon fa fa-cog icon-only bigger-110"></i>
												</button>
												<ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
													<li>
														<a href="{{ url('admin/order/orderDetail') }}/{{$v -> id}}" class="tooltip-info" data-rel="tooltip" title="View">
															<span class="blue">
																<i class="ace-icon fa fa-search-plus bigger-120"></i>
															</span>
														</a>
													</li>
													<li>
														<a href="#" class="tooltip-error" data-rel="tooltip" title="Delete">
															<span class="red">
																<i class="ace-icon fa fa-trash-o bigger-120" onclick="return getid({{ $v -> id }}) "></i>
															</span>
														</a>
													</li>
												</div>
											</td>
										</tr>
							@endforeach
									</tbody>
					</table>
								</div>
				<div style="text-align:center">
					{{ $res -> appends($request) -> links() }}
				</div>
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
<script src="{{ asset('admin/myjs/order/delivering.js') }}"></script>
<script type="text/javascript">
var delUrl="{{ url('admin/order/dels') }}";
var print="{{ url('admin/order/print') }}";
var delsUrl= "{{ url('admin/order/delete') }}";
var libUrl= "{{ url('admin/order/lib') }}";
var isCheckAll = false;
</script>
<script src="{{ asset('admin/components/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('admin/components/tablesorter/jquery.tablesorter.min.js') }}"></script>
<script type="text/javascript">
$(document).ready(function() {
	$("#simple-table").tablesorter({
		headers:{
			0:{sorter:false},
			1:{sorter:false},
			2:{sorter:false},
			3:{sorter:false},
			4:{sorter:false},
			5:{sorter:false},
			7:{sorter:false},
		}
	});
});
</script>
@endsection
