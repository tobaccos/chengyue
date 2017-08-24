<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
<link rel="stylesheet" href="{{ asset('admin/mycss/common/alertwords.css') }}" />
<link rel="stylesheet" href="{{ asset('admin/print.css') }}"  type="text/css" media="print"/>
<link rel="stylesheet" href="{{ asset('admin/assets/css/bootstrap.css') }}"  type="text/css" />
<link rel="stylesheet" href="{{ asset('admin/assets/css/ace.css') }}"  type="text/css"/>
<link rel="stylesheet" href="{{ asset('admin/mycss/order/logistic.css') }}" />
</head>
	<body>
	<div class="div2"  id="printArea">
		<div class="div6">
			<input type="text" name="" id="inp" value="" maxlength="10" style="background-color: transparent;padding: 0px;border:none; color: #fff;" class="col-xs-10 col-sm-5 inp inp1 inpp"/>
		</div>
		<img src="{{url('admin/images/chuhuo.jpg')}}" />
		<div class="div1">
			<div style="float:left">
				<div class="div3">
					<label class="lab">收货人：{{ $data -> name }}</label>
				</div><br></br>
				<div class="div3">
					<label class="lab">付款方式：@if($data -> pay_name == 0 ) 支付宝
						@elseif($data -> pay_name == 1) 余额
						@elseif($data -> pay_name == 2) 微信
						@endif
					</label>
				</div>
			</div>
			<div class="div5">
				<input id="code" type="text" placeholder="输入物流单号" class="col-xs-10 col-sm-5 inpw" style="BACKGROUND-COLOR: transparent;padding: 0px;border:none;" name="code" value="{{ $data-> shipping_code }}" />
				<input id="name" type="text" placeholder="物流名称" class="col-xs-10 col-sm-5 inpw inpname" style="BACKGROUND-COLOR: transparent;padding: 0px;border:none;" name="name" value="{{ $data-> shipping_name }}" />
			</div>
			<table class="table" border="1" cellspacing="0" cellpadding="0" id="biaoge">
				<thead>
					<tr style="background:#e83f18;color:white">
						<th>品牌</th>
						<th>商品名称</th>
						<th>数量</th>
						<th>优惠金额</th>
						<th>运费</th>
					</tr>
					</thead>
					<tbody>
						<th>印汇商盟</th>
						<th>{{ $data -> pname }}</th>
						<th>{{ $data -> num }}</th>
						<th>{{ $data -> dis_count }}</th>
						<th>{{ $data -> logis }}</th>
					</tbody>
				</table >
				<div style="float:left">
					<div class="div3">
	          <label class="lab">商品合计：{{ $data -> order_amount }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;实付总金额：{{ $data -> pay_amount }}</label>
					</div>
	        <div class="div3">
	          <label class="lab">付款时间：{{ $data -> addtime }}</label>
	        </div>
	        <div class="div3">
	          <label class="lab ">收货地址：{{ $data -> address }}</label>
	        </div>
	        <div class="div3">
	          <label class="lab ">温馨提示：{{ $data -> user_note }}</label>
	        </div>
	      </div>
			</div>
		</div>
		@if($data -> order_status == 2)
			<button class="btn btn-xs btn-warning lib butt"  onclick="return libid({{ $data -> id }}) ">出库</button>
		@endif
		<!-- <button class="btn btn-xs btn-info lib butt" id="btnPrint" >打印订单 </button> -->
		@if($data -> order_status == 0)
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
							<input type="hidden" name="id" value="{{ $data -> id }}">
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
	</body>
			<script src="{{ asset('admin/components/jquery/dist/jquery.min.js') }}"></script>
			<script src="{{ asset('admin/jquery.jqprint-0.3.js') }}"></script>
			<script src="{{ asset('admin/jquery-migrate-1.1.0.js') }}"></script>
			<script src="{{ asset('admin/myjs/order/logistic.js') }}"></script>
	    <script>
	    var libUrl= "{{ url('admin/order/lib') }}";
	    </script>
			<script src="{{ asset('admin/jquery.number.js') }}"></script>
			</html>
