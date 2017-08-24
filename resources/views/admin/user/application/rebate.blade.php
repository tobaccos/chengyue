@extends('admin.common.base')
@section('css')
<link rel="stylesheet" href="{{ asset('admin/mycss/common/alertwords.css') }}" />
<link rel="stylesheet" href="{{asset('admin/components/tablesorter/themes/blue/style.css') }}" />
<link rel="stylesheet" href="{{ asset('admin/mycss/user/userClass.css') }}" />
@endsection
@section('first_title','用户管理')
@section('second_title','返利管理')
@section('content')
<button class="btn  btn-xs btn-danger mybtn"  id="update" >
	<i class="ace-icon fa fa-bolt bigger-110"></i>
	更新用户返利
</button>
<div class="nav-search totop" id="nav-search " >
	<form class="form-search" action="{{ url('admin/user/application/rebate') }}">
		<span class="input-icon">
			<input type="text" placeholder="按用户名搜索" class="nav-search-input" maxlength="10"  id="nav-search-input" autocomplete="off" name="keywords"/>
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
				<table id="simple-table" class="table  table-bordered table-hover dataTable tablesorter">
					<thead>
						<tr>
							{{--<th class="center">--}}
								{{--<label class="pos-rel">--}}
									{{--<input type="checkbox" class="ace" onclick="swapCheck()"/>--}}
									{{--<span class="lbl"></span>--}}
								{{--</label>--}}
							{{--</th>--}}
							<th >用户名</th>
							<th >
								<i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i>
								创建时间
							</th>
              <th >当前未提现</th>
              <th >返利总金额</th>
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
								{{ $v -> uname }}
							</td>
							<td>
								{{ $v -> created_at }}
							</td>
							<td>{{ $v -> acc_amount }}</td>
							<td>{{ $v -> rebate_amount }}</td>
							<td>
								<div class="hidden-sm hidden-xs ">
									<a href="{{url('admin/user/application/rebateDetail')}}/{{ $v -> buy_user_id }}">
										<button class="btn btn-xs btn-success">
											查看详情
										</button>
									</a>
								</div>
								<div class="hidden-md hidden-lg">
									<div class="inline pos-rel">
										<button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown" data-position="auto">
											<i class="ace-icon fa fa-cog icon-only bigger-110"></i>
										</button>
										<ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
											<li>
												<a href="{{url('admin/user/application/rebateDetail')}}/{{ $v -> buy_user_id }}" class="tooltip-info" data-rel="tooltip" title="View">
													<span class="blue">
														<i class="ace-icon fa fa-search-plus bigger-120"></i>
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
		<div style="text-align:center">
		{{ $data -> appends($request) -> links() }}
		</div>
	</div>
</div>
@endsection
@section('js')
<script src="{{ asset('admin/myjs/user/rebate.js') }}"></script>
<script>
	var reUrl="{{ url('/toRebate') }}";
</script>
@endsection
