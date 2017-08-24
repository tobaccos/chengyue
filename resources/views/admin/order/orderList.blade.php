@extends('admin.common.base')
@section('css')
<link rel="stylesheet" href="{{ asset('admin/mycss/common/alertwords.css') }}" />
<link rel="stylesheet" href="{{asset('admin/components/tablesorter/themes/blue/style.css') }}" />
<!-- <link rel="stylesheet" href="{{asset('admin/components/tablesorter/addons/pager/jquery.tablesorter.pager.js') }}" /> -->
<link rel="stylesheet" href="{{ asset('admin/mycss/order/list.css') }}" />
@endsection
@section('first_title','订单管理')
@section('second_title','订单列表')

@section('content')
<button class="btn  btn-xs btn-danger mybtn" id="del">
	<i class="ace-icon fa fa-bolt bigger-110"></i>
	批量删除
	<i class="ace-icon fa fa-trash-o icon-only icon-on-right"></i>
</button>
<div class="col-xs-8 col-sm-11 data hidden-480" >
	<form class="form-search" action="{{ url('admin/order/orderList') }}" method="get">
		<div class="input-daterange input-group">
			<input type="text" class="input-sm form-control" placeholder="下单时间搜索" name="start" value="" />
			<span class="input-group-addon">
				<i class="fa fa-exchange"></i>
			</span>
			<input type="text" class="input-sm form-control" placeholder="下单时间搜索" name="end" value="" />
		</div>
		<!-- /section:plugins/date-time.datepicker -->
	</div>
	<select class="col-xs-10 col-sm-5" style="width:15%;" name="status">
	  <option value="">请选择订单状态</option>
    <option value="0">未付款</option>
    <option value="1">付款完成待制作</option>
    <option value="2">制作完成待发货</option>
    <option value="3">商品已发货</option>
    <option value="4">商品已签收</option>
    <option value="5">商品已评论</option>
	</select>
<div class="nav-search totop" id="nav-search " >
		<span class="input-icon">
			<input type="text" placeholder="输入订单号或用户名" class="nav-search-input" maxlength="25" id="nav-search-input" autocomplete="off" name="keyword"/>
			<i class="ace-icon fa fa-search nav-search-icon"></i>
		</span>
		<button type="submit" class="btn btn-xs btn-info searchbtn" >搜索</button>
	</form>
</div>
<div class="row">
	<div class="col-xs-12">
		<!-- PAGE CONTENT BEGINS -->
		<div class="row">
			<div class="col-xs-12">
				<table id="simple-table" class="table  table-bordered table-hover sorttable dataTable tablesorter">
					<thead>
						<tr>
							{{--<th class="center">--}}
								{{--<label class="pos-rel">--}}
									{{--<input type="checkbox" class="ace" onclick="swapCheck()" />--}}
									{{--<span class="lbl"></span>--}}
								{{--</label>--}}
							{{--</th>--}}
							<th>
								<input type="checkbox" value=""   onclick="swapCheck()">&nbsp;全选</input>
							</th>
							<th >订单编号</th>
							<th >用户</th>
							<th class=" hidden-480">商品</th>
							<th class=" hidden-480">商品数量</th>
							<th >应付金额</th>
							<th >实付金额</th>
							<th>订单状态</th>
							<th class=" hidden-480">
								<i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i>
								下单时间
							</th>
							<th>操作</th>
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
							<td class=" hidden-480">
								{{ $v -> pname }}
							</td>
							<td class=" hidden-480">{{ $v -> num }}</td>
							<td>{{ $v -> order_amount }}</td>
							<td>{{ $v -> pay_amount }}</td>
							<td >
								@if( $v -> order_status == 0)
								未付款
								@elseif( $v -> order_status == 1)
								付款完成待制作
								@elseif( $v -> order_status == 2)
								制作完成待发货
								@elseif( $v -> order_status == 3)
								已发货
								@elseif( $v -> order_status == 4)
								已签收
								@elseif( $v -> order_status == 5)
								已评价
								@endif
								<td class=" hidden-480">{{ $v -> addtime }}</td>
								<td>
									<div class="hidden-sm hidden-xs">
										<a href="{{ url('admin/order/orderDetail') }}/{{$v -> id}}"><input type="button" id="man_del" class="btn btn-xs btn-success" value="打印订单"/> </a>
										{{--<button class="btn btn-xs btn-warning lib" onclick="return libid({{ $v -> id }}) ">出库 </button>--}}
										<a href="{{ url('admin/order/logistic') }}/{{$v -> id}}"><input type="button"  class="btn btn-xs btn-warning lib" value="出库"/> </a>
										<a href="{{ url('admin/order/orderDetail') }}/{{$v -> id}}"><input type="button" id="man_del" class="btn btn-xs" value="查看详情"/> </a>
										<button class="btn btn-xs btn-danger del" onclick="return getid({{ $v -> id }}) ">删除 </button>
										@if( $v -> order_status == 0)
										<button class="btn btn-xs btn-yellow lib butt cha" data-toggle="modal" rel="{{ $v -> id }}" data-target=".bs-example-modal-sm">修改价格 </button>
										@endif

										@if( $v -> demand1 || $v -> demand2)
										<a class="btn btn-xs btn-info" href="{{ url('admin/order/orderUpload') }}/{{ $v -> id }}">查看文件</a>
										@endif
									</div>
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
											</ul>
										</div>
									</div>
								</td>
							</div>
						</tr>
						<tr>
						</div>
					</tr>
					@endforeach
				</tbody>
				<div class="modal fade bs-example-modal-sm mod" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="Modal">
					<div class="modal-dialog ">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
								<h4 class="modal-title">输入要修改的价格</h4>
							</div>
							<div class="modal-body">
								<form action="" method="post">
									{{ csrf_field() }}
									<input type="hidden" class="id" name="id" value="">
									<span>修改运费价格：</span><input  onkeyup="if( ! /^\d+(?:.\d{0,2})?$/.test(this.value)){this.value='';}" class="num" type="text" name="logis" value=""><br></br>
									<span>修改优惠价格：</span><input type="text"  onkeyup="if( ! /^\d+(?:.\d{0,2})?$/.test(this.value)){this.value='';}" class="num" name="dis_count" value="">
								</div>
								<div class="modal-footer">
									<button	 type="submit" class="btn btn-sm btn-success">确定</button>
									<a href="#" class="btn btn-sm" data-dismiss="modal">关闭</a>
								</div>
							</form>
						</div>
					</div>
				</div>
			</table>
		</div>
	</div>
	<div id="page" style="text-align:center">
		{{ $res -> appends($request) -> links() }}
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
<script src="{{ asset('admin/myjs/order/list.js') }}"></script>
<script type="text/javascript">
 var isCheckAll = false;
 var delUrl="{{ url('admin/order/dels') }}";
 var delsUrl="{{ url('admin/order/delete') }}";
 var updUrl="{{ url('admin/order/updatePrice') }}";
  var libUrl="{{ url('admin/order/lib') }}";
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
			6:{sorter:false},
			9:{sorter:false},
		}
	});
});
</script>
<script src="{{ asset('admin/jquery.number.js') }}"></script>
@endsection
