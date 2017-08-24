@extends('admin.common.base')
@section('css')
<link rel="stylesheet" href="{{ asset('admin/mycss/common/alertwords.css') }}" />
<link rel="stylesheet" href="{{ asset('admin/mycss/user/angncyList.css') }}" />
<style>
#ver{
  line-height: 2;
}
</style>
@endsection
@section('first_title','用户管理')
@section('second_title','代理商申请列表')
@section('content')
<div class="nav-search totop" id="nav-search">
  <form class="form-search" action="{{ url('admin/user/agency/agencyList') }}" method="get">
    <span class="input-icon">
      <input type="text" placeholder="按代理商名字搜索" class="nav-search-input" id="nav-search-input" autocomplete="off" name="keyword" />
      <i class="ace-icon fa fa-search nav-search-icon"></i>
    </span>
    <button type="submit " class="btn btn-xs btn-info searchbtn">搜索</button>
  </form>
</div>
<div class="row ">
  <div class="col-xs-12">
    <!-- PAGE CONTENT BEGINS -->
    <div class="row">
      <div class="col-xs-12 searchbot">
        <table id="simple-table" class="table  table-bordered table-hover">
          <thead>
            <tr>
              {{--<th class="center">--}}
                {{--<label class="pos-rel">--}}
                  {{--<input type="checkbox" class="ace" onclick="swapCheck()"/>--}}
                  {{--<span class="lbl"></span>--}}
                {{--</label>--}}
              {{--</th>--}}
              <th >申请人</th>
              <th class="hidden-480">申请状态</th>
              <th>电话</th>
              <th class="hidden-480">邮箱</th>
              <th>申请区域</th>
              <th class="hidden-480">
                <i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i>
                申请时间
              </th>
              <th >操作</th>
            </tr>
          </thead>
					<tbody>
						@foreach($data as $v)
						<tr>
							{{--<td class="center">--}}
								{{--<label class="pos-rel">--}}
									{{--<input type="checkbox" class="ace" />--}}
                  {{--<span class="lbl"></span>--}}
                {{--</label>--}}
              {{--</td>--}}
              <td>
								{{ $v -> name }}
              </td>
              <td class="hidden-480" id="ver">
              	@if($v-> dls_apply == 3)
                驳回
                <button class="btn btn-xs btn-grey cha1" style="float:right" data-toggle="modal"  data-target=".bs-example-modal-sm" rel="{{ $v ->id }}">
                  查看原因
                </button>
                @elseif($v -> dls_apply == 2)
                通过
                @elseif($v -> dls_apply == 1)
                未审核
                @endif
              </td>
              <td>
                {{ $v -> phone }}
              </td>
              <td class="hidden-480">{{ $v -> email }}</td>
              <td>{{ $v -> join_address }}</td>
              <td class="hidden-480">{{ $v -> updated_at }}</td>
              <td>
                <div class="hidden-sm hidden-xs ">
                  @if($v -> dls_apply == 1)
                  <a href="{{ url('admin/user/agency/adopt') }}/{{ $v ->id }}">
                    <button class="btn btn-xs btn-success">通过</button>
                  </a>
                  <button class="btn btn-xs btn-warning cha" rel="{{ $v ->id }}" data-toggle="modal" data-target=".bs-example-modal-sm1">
                    驳回
                  </button>
                  @elseif($v -> dls_apply == 2)
                  <button class="btn btn-xs cal" rel="{{ $v ->id }}">
                    取消代理商
                  </button>
          @elseif($v -> dls_apply == 3)
					<a href="{{ url('admin/user/agency/adopt') }}/{{ $v ->id }}">
					<button class="btn btn-xs btn-warning" >通过 </button>
				</a>
          @endif
          {{--<button class="btn btn-xs btn-danger">--}}
            {{--删除--}}
          {{--</button>--}}
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
			</li> -->
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

<textarea style="width:100%" rows="7" name="content" value="" placeholder="请输入驳回原因" ></textarea>

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

			</div>
		</div>
	</div>
</div>
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
<script src="{{ asset('admin/myjs/user/agency.js') }}"></script>
	 <script>
	var showUrl="{{ url('admin/user/agency/show') }}";
  var sucUrl="{{ url('admin/user/agency/cancel') }}/";
	 </script>

	 @endsection
