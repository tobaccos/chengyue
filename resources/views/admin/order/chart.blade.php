@extends('admin.common.base')
@section('css')
<meta http-equiv="X-UA-Compatible" content="IE=7" />
<link rel="stylesheet" href="{{ asset('admin/mycss/common/alertwords.css') }}" />
<link rel="stylesheet" href="{{ asset('admin/mycss/order/chart.css') }}" />
<style>

</style>
@endsection
@section('first_title','订单管理')
@section('second_title','销量曲线图')
@section('content')

	<select value="请选择" id="class1">
		<option value="1">普通产品</option>
		<option value="2">今日推荐</option>
		<option value="3">限时抢购</option>
		<option value="4">活动专区</option>
	</select>
	<select value="请选择"  id="time">
		<option value="7">近七日</option>
		<option value="30">近三十日</option>
		<option value="6">近半年</option>
		<option value="12">近一年</option>
		<option value="30">全部</option>
	</select>
	<select value="请选择"  id="id">
		<option value="0">全部</option>
		@foreach($data as $v)
		<option value="{{ $v -> id }}">{{ $v -> name }}</option>
		@endforeach
	</select>
	<button type="button" name="button" class="btn btn-xs btn-info clickbtn" id="chart">
	生成曲线图
	</button>
<div id="container"></div>
@endsection
@section('js')
<script src="{{ asset('admin/components/jquery/dist/jquery.js') }}"></script>
<script src="{{ asset('admin/components/Highcharts/code/highcharts.js') }}"></script>
<script src="{{ asset('admin/components/Highcharts/code/modules/exporting.js') }}"></script>
<script src="{{ asset('admin/myjs/order/chart.js') }}"></script>
<script language="JavaScript">
var chaUrl="{{ url('admin/order/num') }}";
</script>
@endsection
