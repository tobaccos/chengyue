@extends('admin.common.base')
@section('css')
<link rel="stylesheet" href="{{ asset('admin/mycss/common/alertwords.css') }}" />
<link rel="stylesheet" href="{{ asset('admin/mycss/user/detail.css') }}" />
@endsection
@section('first_title','用户管理')
@section('second_title','返利详情')
@section('content')


	<div>

			<!-- <button class="btn  btn-xs btn-danger myadd" style="float:left" >
				<i class="ace-icon fa fa-bolt bigger-110"></i>
				批量删除
				<i class="ace-icon fa fa-trash-o icon-only icon-on-right"></i>
			</button> -->

				<div class="col-xs-8 col-sm-11 data hidden-480" >
					<form class="form-search" action="{{url('admin/user/application/rebateDetail')}}/{{ $oldId }}" method="get">
					<div class="register">
						<span>返利日期区间:</span></div>
						<div class="input-daterange input-group ">
							<input type="text" class="input-sm form-control" name="start" />
							<span class="input-group-addon">
								<i class="fa fa-exchange"></i>
							</span>
							<input type="text" class="input-sm form-control" name="end" />
						</div>
						<!-- /section:plugins/date-time.datepicker -->
					</div>
					<div class="nav-search totop" id="nav-search " >

							<span class="input-icon">
								<input type="text" placeholder="请输入购买人" class="nav-search-input" id="nav-search-input" autocomplete="off" name="keyword"/>
								<i class="ace-icon fa fa-search nav-search-icon"></i>
							</span>
							<button type="submit" class="btn btn-xs btn-info searchbtn" >搜索</button>
						</form>
					</div>


		</div>

	<div class="row">
		<div class="col-xs-12">
			<!-- PAGE CONTENT BEGINS -->
			<div class="row">
				<div class="col-xs-12">
					<table id="simple-table" class="table  table-bordered table-hover sorttable dataTable">
						<thead>
							<tr><!-- 
								<th class="center">
									<label class="pos-rel">
										<input type="checkbox" value=""   onclick="swapCheck()">&nbsp;全选</input>
										<span class="lbl"></span>
									</label>
								</th> -->
								<th>购买人</th>
								<th>订单编号</th>
								<th>订单金额</th>
								<th>获佣金额</th>
								<th>
									<i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i>
									分成记录生成时间</th>
									<th >
										<i class="ace-icon fa fa-clock-o bigger-110 hidden-480">
										</i>确认收货时间
									</th>
									<th >
											状态
										</th>
										<th >操作</th>
									</tr>
								</thead>
								<tbody>
                                @foreach($data as $v)
									<tr>
										<!-- <td class="center">
											<label class="pos-rel">
												<input type="checkbox" />
												<span class="lbl"></span>
											</label>
										</td> -->
										<td>{{ $v -> name }}</td>
										<td>{{ $v -> order_sn }}	</td>
										<td> {{ $v -> pro_price }}</td>
										<td>{{ $v -> money }}</td>
										<td>{{ $v -> created_at }}</td>
										<td class="hidden-480">{{ $v -> confirm }}</td>
										<td>
                                            @if($v -> state ==0)
                                                未付款
                                             @elseif($v -> state ==1)
                                               待收货
                                             @elseif($v -> state ==2)
                                                等待分成(已收货)
                                             @elseif($v -> state ==3)
                                                已分成
                                            @else
                                               已取消
                                            @endif

                                        </td>
										<td>
									 <div class="hidden-sm hidden-xs ">
										 <button class="btn btn-xs btn-danger del" value="{{ $v ->id }}" >
											 删除记录
										 </button>
										 <div class="hidden-md hidden-lg">
											 <div class="inline pos-rel">
												 <button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown" data-position="auto">
													 <i class="ace-icon fa fa-cog icon-only bigger-110"></i>
												 </button>
												 <ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
													 <!-- <li>
														 <a href="#" class="tooltip-info" data-rel="tooltip" title="View">
															 <span class="blue">
																 <i class="ace-icon fa fa-search-plus bigger-120"></i>
															 </span>
														 </a>
													 </li>
													 <li>
														 <a href="#" class="tooltip-success" data-rel="tooltip" title="Edit">
															 <span class="green">
																 <i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
															 </span>
														 </a>
													 </li> -->
													 <li>
														 <a href="#" class="tooltip-error" data-rel="tooltip" title="Delete">
															 <span class="red">
																 <i class="ace-icon fa fa-trash-o bigger-120"></i>
															 </span>
														 </a>
													 </li>
												 </ul>
											 </div>
										 </div>
									 </td>
								 </div>
							 </tr>
                @endforeach
						 </tbody>
					 </table>
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
	<script src="{{ asset('admin/myjs/user/reb.js') }}"></script>
	<script type="text/javascript">
	var isCheckAll = false;
    var reddUrl="{{ url('admin/user/application/redel') }}"
		</script>
		@endsection
