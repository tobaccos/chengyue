@extends('admin.common.base')
@section('css')
<link rel="stylesheet" href="{{ asset('admin/mycss/common/alertwords.css') }}" />
<link rel="stylesheet" href="{{ asset('admin/mycss/user/userClass.css') }}" />
<style>
#ver{
  line-height: 2;
}
#layui-layer1{
  width: 500px;
  height: 100px ;
}
	</style>
@endsection
@section('first_title','用户管理')
@section('second_title','提现申请')
@section('content')

		<button class="btn  btn-xs btn-danger mybtn" id="del">
			<i class="ace-icon fa fa-bolt bigger-110"></i>
			批量删除
			<i class="ace-icon fa fa-trash-o icon-only icon-on-right"></i>
		</button>
<div class="row">
	<div class="col-xs-12">
		<!-- PAGE CONTENT BEGINS -->
		<div class="row">
			<div class="col-xs-12">
				<table id="simple-table" class="table  table-bordered table-hover">
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
              <th class="hidden-480">序号</th>
              <th>申请人</th>
              <th>提现金额</th>
              <th class="hidden-480">提现类型</th>
              <th>提现账号</th>
              <th class="hidden-480">
                <i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i>
                申请时间
              </th>
              <th>状态</th>
              <th class="hidden-480">备注</th>
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
						<td class="hidden-480">{{ $v -> id }}</td>
            <td>{{ $v -> name }}</td>
            <td>{{ $v -> money }}</td>
            <td class="hidden-480">{{ $v -> bank_name }}</td>
            <td>{{ $v -> bank_num }}</td>
						<td class="hidden-480">{{ $v -> created_at }}</td>
      			<td id="ver">
							@if($v -> state == 0)
							申请中
							@elseif($v -> state == 1)
							通过
							@elseif($v -> state == 2)
							驳回
							<button class="btn btn-xs btn-grey cha1" style="float:right" data-toggle="modal" data-target=".bs-example-modal-sm" rel="{{ $v ->id }}">
								查看原因
							</button>
							@endif
						</td>
				    <td class="hidden-480">{{ $v -> remark }}</td>
				    <td>
							<div class="hidden-sm hidden-xs ">
								@if($v -> state == 0)
								<a href="{{ url('admin/user/application/adpot') }}/{{ $v -> id }}"> <button class="btn btn-xs btn-success">通过</button> </a>
								<button class="btn btn-xs btn-warning cha " rel="{{ $v -> id }}" data-toggle="modal" data-target=".bs-example-modal-sm1" > 拒绝 </button>
								@else
								<button class="btn btn-xs btn-success" disabled>通过</button>
								<button class="btn btn-xs btn-warning" disabled > 拒绝 </button>
								@endif
				        <button class="btn btn-xs btn-danger del" onclick="return getid({{ $v -> id }}) ">删除 </button>
							</div>
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
											<a onclick="return getid({{ $v -> id }}) " class="tooltip-error" data-rel="tooltip" title="Delete">
												<span class="red">
													<i class="ace-icon fa fa-trash-o bigger-120"></i>
												</span>
											</a>
										</li>
									</ul>
								</div>
							</div>

				</div>
			</td>
		</tr>
		@endforeach
	</tbody>

		<div class="modal fade bs-example-modal-sm1" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="Modal">
			<div class="modal-dialog " style="margin: 120px auto;">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<h4 class="modal-title">拒绝原因</h4>
						<div class="modal-body" >
							<form action="" method="post">
								{{ csrf_field() }}
							<textarea style="width:100%" rows="7" name="reject" value=""  > </textarea>
						</div>
						<div class="modal-footer">
							<button	 type="submit" class="btn btn-sm">确定</button>
							<a href="#" class="btn btn-sm" data-dismiss="modal">关闭</a>
						</div>
						</form>
					</div>
				</div>
			</table>
			<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="Modal1">
			<div class="modal-dialog ">
			<div class="modal-content">
			<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			<h4 class="modal-title">驳回原因</h4>
		</div>
		<div class="modal-body" style="height:200px;font-size:16px">
			<!-- <textarea style="width:100%" rows="7" name="content" value=""  disabled></textarea> -->

		</div>
	</div>
</div>
</div>
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
<script src="{{ asset('admin/myjs/user/appm.js') }}"></script>
<script type="text/javascript">
var isCheckAll = false;
	var geUrl="{{ url('admin/user/application/delete') }}";
	var cha1Url="{{ url('admin/user/application/show') }}";
	var delUrl="{{ url('admin/user/application/dels') }}";
	</script>

	@endsection
