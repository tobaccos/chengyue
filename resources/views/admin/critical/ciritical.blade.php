@extends('admin.common.base')
@section('css')
<link rel="stylesheet" href="{{ asset('admin/mycss/common/alertwords.css') }}" />
<link rel="stylesheet" href="{{ asset('admin/mycss/order/cit111.css') }}" />
<style>
#ver{
  line-height: 30px;
}
	</style>
@endsection
@section('first_title','评论')
@section('second_title','评论管理')
@section('content')
<div class="row">
	<div class="col-xs-12">
		<div class="row">
			<div class="col-xs-12">
        <table id="simple-table" class="table  table-bordered table-hover">
          <thead>
            <tr>
							<!-- <th>
								<input type="checkbox" value=""   onclick="swapCheck()">&nbsp;全选</input>
							</th> -->
              <th >评论ID</th>
              <th >用户名</th>
              <th >产品</th>
              <th class="hidden-480">评论内容</th>
							<th class="hidden-480">评论图片</th>
              <th class="hidden-480">
								<i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i>
								状态
							</th>
							<th >时间</th>
              <th >操作</th>
            </tr>
					</thead>
					<tbody>
						<tr>
							@if(!$data)
							<td colspan="9" align="center"><font color="#ff3600" size="3">提示:暂时没有评论信息</font></td>
							@else
							@foreach($data as $value)
							@foreach($value as $v)
							<!-- <td class="center">
								<label class="pos-rel">
									<input type="checkbox" />
									<span class="lbl"></span>
								</label>
							</td> -->
							<td>{{ $v -> id }} </td>
							<td>{{ $v -> uname }}</td>
							<td class="hidden-480">{{ $v -> pname }}</td>
							<td class="hidden-480">{{ $v -> content }}</td>
							<td><img src="{{ url('/uploads/comment') }}/{{ $v -> image }}" width="50"></td>
							<td class="hidden-480" id="ver">
								@if($v -> state == 0)
								未处理
								@elseif($v -> state == 1)
								已通过
								@elseif($v -> state == 2)
								<span style="opacity: 0.8;">已驳回</span>
								<button class="btn btn-xs btn-grey cha1" style="float:right" data-toggle="modal"  data-target=".bs-example-modal-sm" rel="{{ $v -> id }}">
									查看原因
								</button>
								@endif
							</td>
							<td>{{ $v -> ctime }}</td>
							<td>
								<div class="hidden-sm hidden-xs ">
									@if($v -> state == 0)
									<button class="btn btn-xs btn-success" rel="{{ $v -> id }}">通过</button>
									<button class="btn btn-xs btn-warning cha" rel="{{ $v -> id}}" data-toggle="modal" data-target=".bs-example-modal-sm1">
										驳回
									</button>
									<button class="btn btn-xs btn-danger" rel="{{ $v -> id }}"> 删除 </button>
									@elseif($v -> state == 1)
									<button disabled="disabled" class="btn btn-xs btn-success" rel="{{ $v -> id }}">通过</button>
									<button disabled="disabled" class="btn btn-xs btn-warning cha" rel="{{ $v -> id}}" data-toggle="modal" data-target=".bs-example-modal-sm1">
										驳回
									</button>
									<button class="btn btn-xs btn-danger" rel="{{ $v -> id }}"> 删除 </button>
									@elseif($v -> state == 2)
									<button disabled="disabled" class="btn btn-xs btn-success" rel="{{ $v -> id }}">通过</button>
									<button disabled="disabled" class="btn btn-xs btn-warning cha" rel="{{ $v -> id}}" data-toggle="modal" data-target=".bs-example-modal-sm1">
										驳回
									</button>
									<button class="btn btn-xs btn-danger" rel="{{ $v -> id }}"> 删除 </button>
									@endif
								</div>
								<div class="hidden-md hidden-lg">
									<div class="inline pos-rel">
										<button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown" data-position="auto">
											<i class="ace-icon fa fa-cog icon-only bigger-110"></i>
										</button>
										<ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
											<li>
												<a href="#" class="tooltip-success" data-rel="tooltip" title="Edit">
													<span class="green">
														<i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
													</span>
												</a>
											</li>
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
					@endforeach
					@endif
					<div class="modal fade bs-example-modal-sm1" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="Modal">
						<div class="modal-dialog " style="margin: 120px auto;">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
									<h4 class="modal-title">驳回原因</h4>
								</div>
								<div class="modal-body">
									<form action='' method="post">
										{{ csrf_field() }}
										<textarea style="width:100%" rows="7" name="content" value="" placeholder="请输入驳回原因(字数不得多于50字)" maxlength="50"  required oninvalid="setCustomValidity('输入内容不能为空!');" ></textarea>
									</div>
								</div>
								<div class="modal-footer">
									<button	 type="submit" class="btn btn-sm">确定</button>
									<a href="#" class="btn btn-sm" data-dismiss="modal">关闭</a>
								</form>
							</div>
						</div>
					</div>
					<!-- 模态框 -->
					<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="Modal1">
						<div class="modal-dialog ">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
									<h4 class="modal-title">驳回原因</h4>
								</div>
								<div class="modal-body" style="height:200px;font-size:16px">
									@foreach($data as $k => $value)
									@foreach($value as $k => $v)
									{{ $v -> text }}
									@endforeach
									@endforeach
								</div>
							</div>
						</div>
					</div>
				</tbody>
			</table>
		</div>
	</div>

	<div style="text-align:center">
		{{ $oId -> appends($request) -> links() }}
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
<script src="{{ asset('admin/myjs/order/cit111.js') }}"></script>
<script type="text/javascript">
 var isCheckAll = false;
 var calUrl="{{ url('admin/user/agency/cancel') }}/";
 var sucUrl= "{{ url('admin/critical/ciriticalAdpot') }}/";
 var danUrl="{{ url('admin/critical/ciriticalDelete') }}/";
	</script>
	 @endsection
