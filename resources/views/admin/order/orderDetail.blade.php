@extends('admin.common.base')
@section('css')
<link rel="stylesheet" href="{{ asset('admin/mycss/common/alertwords.css') }}" />
<!-- <link rel="stylesheet" href="{{ asset('admin/print.css') }}"  type="text/css" media="print"/> -->
<!-- <link rel="stylesheet" href="{{ asset('admin/assets/css/bootstrap.css') }}"  type="text/css" media="print"/> -->
<link rel="stylesheet" href="{{ asset('admin/assets/css/ace.css') }}"  type="text/css" media="print"/>
<link rel="stylesheet" href="{{ asset('admin/assets/css/bootstrap.css') }}"  type="text/css" media="print"/>
<link rel="stylesheet" href="{{ asset('admin/mycss/order/logistic0.css') }}" />
<link rel="stylesheet" href="{{ asset('admin/mycss/order/logistic0.css') }}" type="text/css" media="print"/>
@endsection
@section('first_title','首页')
@section('second_title','订单详情')
@section('content')
<div class="page-header">
	<h1>
		订单详情
		<small>
			<a href="javascript:" onclick="self.location=document.referrer;">
				<button class="btn btn-xs return btn-info" style="float:right">
					<!-- <i class="ace-icon fa fa-arrow-left icon-on-left"> -->
					返回
				</button>
			</a>
		</small>
	</h1>
</div><!-- /.page-header -->
<div class="allWid" id="allWid">
	<div  id="printArea" >
	<div>
		<table id="tabb" border="1" cellspacing="0" cellpadding="0" >
			<thead>
				<tr >
				<td colspan="5" class="tdn tdn1">
					<img src="{{url('admin/images/logocc.png')}}" class="logoImg"/><label class="logoLab">一家专业做印刷广告的网站</label>
					<div class="toRight topRig1">
					<img src="{{url('admin/images/tel.png')}}"  class="telImg"/><label>0312-6611776</label>
					<img src="{{url('admin/images/QQ.png')}}"  class="qqImg"/><label>1702688880</label>
				</div>
			</td>
		</tr>
				<tr>
				<td colspan="5" class="lee tdn tdn1">
					<label class="fz">收货人：{{ $dingdan -> name }}</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<label class="fz">收货人电话：{{ $date -> phone }}</label>
			</td>
		</tr>
		<tr>
				<td colspan="5" class="lee tdn tdn1">
				<label class="col-4 fz">快递名称：<input id="name"  type="text" class="fz" placeholder="自营物流" value="{{ $dingdan -> shipping_name }}" /></label>
				<label  class="col-3 fz">快递单号：<input id="code"  type="text" class="fz" placeholder="输入物流单号" value="{{ $dingdan -> shipping_code }}" /></label>
				<label  class="col-5 fz">收货地址：{{ $date -> address }}</label>
			</td>
		</tr>
				<tr>
					<th>商品名称</th>
					<!-- <th>规格</th> -->
					<th>数量</th>
					<th>单位</th>
					<th>优惠金额</th>
					<th>用户备注</th>
				</tr>
			</thead>
			<tbody>
			@foreach($data as $v)
				<tr>
					<td>{{ $v -> pname }}</td>
					<!-- <td>121</td> -->
					<td>{{ $v -> num }}</td>
					<td>{{ $v -> unit }}</td>
					<td>{{ $v -> dis_count }}</td>
					<td>{{ $v -> user_note }}</td>
				</tr>
			@endforeach	
				<tr  style="border:none;">
					<td colspan="4" class="lee tdn "><label class="fz">商品合计：{{ $dingdan -> pay_amount }}</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<label class="fz">付款时间：{{ $dingdan -> addtime }}</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<label class="fz">支付方式：@if($dingdan -> pay_name == 0 )支付宝@elseif($dingdan -> pay_name == 1)余额@elseif($dingdan -> pay_name == 2)微信@endif</label></td>
					<td  rowspan="2" class="tdn tdn1">  <img src="{{url('admin/images/ma.jpg')}}"  class="logoImg" style="float:right;"/></td>
				</tr>
				<tr>
					<td colspan="6" class="lee tdn">  <label class="fz">备注：</label></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
</div>
<div class="autt">
		@if($dingdan -> order_status == 2)
			<button class="btn btn-xs btn-warning lib butt"  onclick="return libid({{ $dingdan -> id }}) ">出库</button>
		@endif
		<button class="btn btn-xs btn-info lib butt" id="btnPrint" >打印订单 </button>
		@if($dingdan -> order_status == 0)
			<button class="btn btn-xs btn-success lib butt" data-toggle="modal" data-target=".bs-example-modal-sm">修改价格</button>
		@endif
		<form action="{{ url('admin/order/updatePrice') }}" method="post">
			{{ csrf_field() }}
			<div class="modal fade bs-example-modal-sm mod" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
				<div class="modal-dialog ">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
							<h4 class="modal-title">输入要修改的价格</h4>
						</div>
						<div class="modal-body">
							<input type="hidden" name="id" value="{{ $dingdan -> id }}">
							<span>修改运费价格：</span><input class="num"  onkeyup="value=value.replace(/[^\d{1,}\.\d{1,}|\d{1,}]/g,'')" type="text" name="logis" value=""><br></br>
							<span>修改优惠价格：</span><input type="text"  onkeyup="value=value.replace(/[^\d{1,}\.\d{1,}|\d{1,}]/g,'')" class="num" name="dis_count" value="">
						</div>
						<div class="modal-footer">
							<button	 type="submit" class="btn btn-sm">确定</button>
							<a href="#" class="btn btn-sm" data-dismiss="modal">关闭</a>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
		@endsection
		@section('js')
			<script src="{{ asset('admin/components/jquery/dist/jquery.min.js') }}"></script>
			<script src="{{ asset('admin/jquery.jqprint-0.3.js') }}"></script>
			<script src="{{ asset('admin/jquery-migrate-1.1.0.js') }}"></script>
			<script src="{{ asset('admin/myjs/order/logistic.js') }}"></script>
	   <script>
    var libUrl= "{{ url('admin/order/lib') }}";
    var Heig=$("#printArea").height();
    var Hd=320;
    var abc = Math.ceil(Heig/Hd);
    console.log(Heig);
    if(Heig<=Hd){
      $('#printArea').css("height","320px");
   $('#tabb').css("height","320px");
    }
    else{
      $('#printArea').css("height",Hd*abc);
    }
    console.log("height",$("#printArea").height());
    </script>
			<script src="{{ asset('admin/jquery.number.js') }}"></script>

@endsection
