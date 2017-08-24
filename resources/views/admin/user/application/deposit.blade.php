@extends('admin.common.base')
@section('css')
<link rel="stylesheet" href="{{ asset('admin/mycss/common/alertwords.css') }}" />
<link rel="stylesheet" href="{{ asset('admin/mycss/user/userClass.css') }}" />
<style>
#ver{
  line-height: 2;
}
	</style>
@endsection
@section('first_title','用户管理')
@section('second_title','押金提现')
@section('content')

		<button class="btn  btn-xs btn-danger mybtn" id="mydel">
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
						  <th >操作</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td class="center">
								<label class="pos-rel">
								<input type="checkbox"  name="id" value="" />
								<span class="lbl"></span>
							</label>
						</td>
						<td class="hidden-480">01</td>
						<td>乔俊雪</td>
						<td>10000</td>
						<td class="hidden-480">支付宝</td>
						<td>6217000130006221401</td>
						<td class="hidden-480">2017.06.06</td>
      			        <td id="ver">
							{{--@if($v -> state == 0)--}}
							{{--申请中--}}
							{{--@elseif($v -> state == 1)--}}
							{{--通过--}}
							{{--@elseif($v -> state == 2)--}}
							驳回
							<button class="btn btn-xs btn-grey cha1" style="float:right" data-toggle="modal" data-target=".bs-example-modal-sm">
								查看原因
							</button>
							{{--@endif--}}
						 </td>
				         <td>
							<div class="hidden-sm hidden-xs ">
								{{--@if($v -> state == 0)--}}
								{{--<a href="{{ url('admin/user/application/adpot') }}/{{ $v -> id }}"> <button class="btn btn-xs btn-success">通过</button> </a>--}}
								{{--<button class="btn btn-xs btn-warning cha " rel="{{ $v -> id }}" data-toggle="modal" data-target=".bs-example-modal-sm1" > 拒绝 </button>--}}
								{{--@else--}}
								<button class="btn btn-xs btn-success" disabled>通过</button>
								<button class="btn btn-xs btn-warning" disabled > 拒绝 </button>
								{{--@endif--}}
								<button class="btn btn-xs btn-danger del" onclick="delCate({{$v['id']}})">删除 </button>
							</div>
							<div class="hidden-md hidden-lg">
								<div class="inline pos-rel">
									<button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown" data-position="auto">
										<i class="ace-icon fa fa-cog icon-only bigger-110"></i>
									</button>
									<ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
										<li>
											<a onclick=" " class="tooltip-error" data-rel="tooltip" title="Delete">
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
		{{--@endforeach--}}
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
		</div>
	</div>
</div>
</div>
</div>
</div>
<div style="text-align:center">
{{--{{ $data -> appends($request) -> links() }}--}}
</div>
</div>
</div>
@endsection
@section('js')
<script type="text/javascript">
    //批量删除地址
   // var delUrl="{{url('admin/product/dels')}}";
    //单个删除地址
    //var singleDel="{{url('admin/product')}}/";
</script>
{{--单个删除--}}
<script src="{{ asset('admin/myjs/promanage/singleDel.js') }}"></script>
{{--批量删除--}}
<script src="{{ asset('admin/myjs/promanage/del.js') }}"></script>
@endsection
