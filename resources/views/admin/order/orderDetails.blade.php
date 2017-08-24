<HTML>
	<head>
		<script  language="javascript" type="text/javascript">function printwithoutsetup() {
	var a;
	a = document.getElementById("TestAX");
	var btn = document.getElementById('prin1');
	a.Mar_left = 13;
	a.Mar_Top = 1.5;
	a.Mar_Right = 13;
	a.Mar_Bottom = 1.5;
	a.Orientation = "横向";
	a.Paper_Size = "Folio";
	a.Header_Html = "Headeraaaaaaaa";
	a.
	er_Html = "Footerssssssss";
	btn.style.display = "none";
	a.ApplySetup();
	a.PrintWithOutSetup();
}

function preview() {
	var a;
	var btn = document.getElementById('prin1');
	a = document.getElementById("TestAX");
	a.Mar_left = 3.5;
	a.Mar_Top = 1.5;
	a.Mar_Right = 13;
	a.Mar_Bottom = 1.5;
	a.Orientation = "向";
	a.Paper_Size = "A0";
	a.Header_Html = "Headeraaaaaaaa";
	a.Footer_Html = "Footerssssssss";
	btn.style.display = "none";
	a.ApplySetup();
	a.PrintPreView();

}

function printwithsetup() {
	var a;
	a = document.getElementById("TestAX");
	var btn = document.getElementById('prin1');
	a.Mar_left = 13;
	a.Mar_Top = 1.5;
	a.Mar_Right = 13;
	a.Mar_Bottom = 1.5;
	a.Orientation = "向";
	a.Paper_Size = "A4";
	a.Header_Html = "Headeraaaaaaaa";
	a.Footer_Html = "Footerssssssss";
	btn.style.display = "none";
	a.PrintWithSetup();
}

function printwithoutsetup2() {
	var a;
	var b;
	a = document.getElementById("TestAX");
	var btn = document.getElementById('prin1');
	a.Mar_left = 13;
	a.Mar_Top = 1.5;
	a.Mar_Right = 13;
	a.Mar_Bottom = 1.5;
	a.Orientation = "横向";
	a.Paper_Size = "Folio";
	a.Header_Html = "Headeraaaaaaaa";
	a.Footer_Html = "Footerssssssss";
	btn.style.display = "none";
	a.ApplySetup();
	a.PrintWithOutSetupPrintByID("163");
}

function printwithoutsetup3() {
	var a;
	var b;
	a = document.getElementById("TestAX");
	var btn = document.getElementById('prin1');
	a.Mar_left = 13;
	a.Mar_Top = 1.5;
	a.Mar_Right = 13;
	a.Mar_Bottom = 1.5;
	a.Orientation = "纵向";
	a.Paper_Size = "Folio";
	a.Header_Html = "Headeraaaaaaaa";
	a.Footer_Html = "Footerssssssss";
	btn.style.display = "none";
	a.ApplySetup();
	a.PrintWithOutSetupPrintWithOutByID("cnnb");
}

function printwithoutsetup4() {
	var a;
	var b;
	a = document.getElementById("TestAX");
	var btn = document.getElementById('prin1');
	a.Mar_left = 13;
	a.Mar_Top = 1.5;
	a.Mar_Right = 13;
	a.Mar_Bottom = 1.5;
	a.Orientation = "纵向";
	a.Paper_Size = "Folio";
	a.Header_Html = "Headeraaaaaaaa";
	a.Footer_Html = "Footerssssssss";
	a.Form_Width = 100;
	a.Form_Height = 200;
	a.Caption = "我来测试";
	a.Color = 1234123;
	btn.style.display = "none";
	a.ApplySetup();
	a.PrintWithOutSetup();
}</script>
		<meta charset="UTF-8">
		<title>Document</title>
		<link rel="stylesheet" href="{{ asset('admin/mycss/common/alertwords.css') }}" />
		<link rel="stylesheet" href="{{ asset('admin/print.css') }}"  type="text/css" media="print"/>
		<link rel="stylesheet" href="{{ asset('admin/assets/css/bootstrap.css') }}"  type="text/css" />
		<link rel="stylesheet" href="{{ asset('admin/assets/css/ace.css') }}"  type="text/css"/>
		<link rel="stylesheet" href="{{ asset('admin/mycss/order/logistic0.css') }}" />
		<!-- /*<style type="text/css">
		label{
		font-size: 20px !important;
		margin-top: 5px;
		}
		.inpw{
		font-size: 20px !important;
		}
		</style>*/ -->
	</head>
	<body style="margin: 0 auto;">
		<div style="display:none">
			<OBJECT ID="TestAX" classid="clsid:AE1A309B-6FFA-4FCF-B07F-CB97FFD56B1B" codebase="IEprint.ocx#version=" width=0 height=0 align=center hspace=0  vspace=0 ></OBJECT>
		</div>
		<div style="margin:25px auto;text-align:center;"id="prin1" >
			<input type="button"  onClick="printwithoutsetup();" value="直接打印">
			<input type="button" onClick="preview()" value="直接预览">
			<input type="button" onClick="printwithsetup();" value="有设置打印">
			<input type="button" onClick="printwithoutsetup2();" value="只打印163">
			<input type="button" onClick="printwithoutsetup3();" value="不打印cnnb">
			<input type="button" onClick="printwithoutsetup4();" value="直接打印改样式">
		</div>

		@foreach($data as  $k => $v)
		{{--//判断是否是子订单--}}
		@if(isset($v -> name))
		{{--//下面是子订单--}}
			@if($loop ->index ==0)
		<div class="allWid " id="allWid" >
			<div  id="printArea"  class="printArea">
				<div>
					<table id="tabb" border="1" cellspacing="0" cellpadding="0" >
						<thead>
							<tr >
								<td colspan="5" class="tdn tdn1">
									<img src="{{url('admin/images/logocc.png')}}" class="logoImg"/>
									<label class="logoLab">一家专业做印刷广告的网站</label>
									<div class="toRight topRig1">
										<img src="{{url('admin/images/tel.png')}}"  class="telImg"/>
										<label class="tela">0312-6611776</label>
										<img src="{{url('admin/images/QQ.png')}}"  class="qqImg"/>
										<label class="tela">1702688880</label>
									</div></td>
							</tr>
							<tr>
								<td colspan="5" class="lee tdn tdn1"> {{--<label class="fz fz1 fl">自营物流单号：</label>--}}
									 <label class="fz  fz1 fphone">收货人：{{ $date[$k] ->name }}</label>
									<label class="fz  fz1 ">收货人电话：{{ $date[$k] -> phone }}</label>
									<label class="fz  fz1 fr">[1-1]</label>
									 </td>
							</tr>
							<tr id="address">
								<td colspan="5" class="lee tdn tdn1"><label class="col-4 fz fl">快递名称： <span id="name"  type="text" class="fz">{{ $date[$k] -> shipping_name }}</span> </label><label  class="col-3 fz fl">快递单号： <span id="code"  type="text" class="fz" >012345678901234567890{{ $date[$k] -> shipping_code }}</span> </label>
									<p  class="col-5 fz fl">收货地址： <span id="code"  type="text" class="fz">{{ $date[$k] -> address }}</span> </p></td>
							</tr >
							<tr id="goods">
								<th>商品名称</th>
								<!-- <th>规格</th> -->
								<th>数量</th>
								<th>单位</th>
								<th>优惠金额</th>
								<th>客户备注</th>
							</tr>
						</thead>
						<tbody>
							<tr class="goods">
								<td>{{ $v -> pname }}</td>
								<!-- <td>121</td> -->
								<td>{{ $v -> num }}</td>
								<td>{{ $v -> unit }}</td>
								<td>{{ $v -> dis_count }}</td>
								<td>{{ $v -> user_note }}</td>
							</tr>
						</tbody>
					</table>

				</div>
						<div class="foot">
					<div  style="border:none;">
						<td colspan="4" class="lee tdn "><label class="fz">商品合计：{{ $date[$k] -> pay_amount }}</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <label class="fz">付款时间：{{ $date[$k] -> addtime }}</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <label class="fz">支付方式：@if($date[$k] -> pay_name == 0 )支付宝@elseif($date[$k] -> pay_name == 1)余额@elseif($date[$k] -> pay_name == 2)微信@endif</label></td>
						<td  rowspan="2" class="tdn tdn1">
							<img src="{{url('admin/images/ma.jpg')}}"  class="logoImg" style="float:right;"/>
						</td>
					</div>

					<div>
						<td colspan="6" class="lee tdn"><label class="fz">备注：</label><label class="fz fr pad">客户签字：</label></td>
					</div>
				</div>
			</div>
		</div>
		
		@else
		<div class="allWid " id="allWid" style="position:relative;top: {{($loop ->index)*(-8)}}px;">
			<div  id="printArea"  class="printArea" >
				<div>
					<table id="tabb" border="1" cellspacing="0" cellpadding="0" >
						<thead>
							<tr >
								<td colspan="5" class="tdn tdn1">
									<img src="{{url('admin/images/logocc.png')}}" class="logoImg"/>
									<label class="logoLab">一家专业做印刷广告的网站</label>
									<div class="toRight topRig1">
										<img src="{{url('admin/images/tel.png')}}"  class="telImg"/>
										<label class="tela">0312-6611776</label>
										<img src="{{url('admin/images/QQ.png')}}"  class="qqImg"/>
										<label class="tela">1702688880</label>
									</div></td>
							</tr>
							<tr>
								<td colspan="5" class="lee tdn tdn1"> {{--<label class="fz fz1 fl">自营物流单号：</label>--}}
									 <label class="fz  fz1 fphone">收货人：{{ $date[$k] ->name }}</label>
									<label class="fz  fz1 ">收货人电话：{{ $date[$k] -> phone }}</label>
									<label class="fz  fz1 fr">[1-1]</label>
									 </td>
							</tr>
							<tr id="address">
								<td colspan="5" class="lee tdn tdn1"><label class="col-4 fz fl">快递名称： <span id="name"  type="text" class="fz">{{ $date[$k] -> shipping_name }}</span> </label><label  class="col-3 fz fl">快递单号： <span id="code"  type="text" class="fz" >012345678901234567890{{ $date[$k] -> shipping_code }}</span> </label>
									<p  class="col-5 fz fl">收货地址： <span id="code"  type="text" class="fz">{{ $date[$k] -> address }}</span> </p></td>
							</tr >
							<tr id="goods">
								<th>商品名称</th>
								<!-- <th>规格</th> -->
								<th>数量</th>
								<th>单位</th>
								<th>优惠金额</th>
								<th>客户备注</th>
							</tr>
						</thead>
						<tbody>
							<tr class="goods">
								<td>{{ $v -> pname }}</td>
								<!-- <td>121</td> -->
								<td>{{ $v -> num }}</td>
								<td>{{ $v -> unit }}</td>
								<td>{{ $v -> dis_count }}</td>
								<td>{{ $v -> user_note }}</td>
							</tr>
							
						</tbody>
					</table>

				</div>
						<div class="foot">
					<div  style="border:none;">
						<td colspan="4" class="lee tdn "><label class="fz">商品合计：{{ $date[$k] -> pay_amount }}</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <label class="fz">付款时间：{{ $date[$k] -> addtime }}</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <label class="fz">支付方式：@if($date[$k] -> pay_name == 0 )支付宝@elseif($date[$k] -> pay_name == 1)余额@elseif($date[$k] -> pay_name == 2)微信@endif</label></td>
						<td  rowspan="2" class="tdn tdn1">
							<img src="{{url('admin/images/ma.jpg')}}"  class="logoImg" style="float:right;"/>
						</td>
					</div>

					<div>
						<td style="width: 100%;" class="lee tdn"><label class="fz fl">备注：</label><label class="fz fr pad">客户签字：</label></td>
					</div>
				</div>
			</div>
		</div>
		@endif
		@else
		{{--//下面是父订单--}}

		@foreach($data2[$k] as $keys => $value)
		{{--//判断是否需要隐藏logo--}}
	@if(!empty($value))
			@if($loop ->index ==0)
		<div class="allWid " id="allWid" style="position:relative;top: {{(($loop ->index)+($loop ->parent ->index))*(-8)}}px;">
			<div  id="printArea" class="printArea">
				<div>
					<table id="tabb" border="1" cellspacing="0" cellpadding="0" >
						<thead>
							<tr >
								<td colspan="5" class="tdn tdn1">
									<img src="{{url('admin/images/logocc.png')}}" class="logoImg"/>
									<label class="logoLab">一家专业做印刷广告的网站</label>
									<div class="toRight topRig1">
										<img src="{{url('admin/images/tel.png')}}"  class="telImg"/>
										<label class="tela">0312-6611776</label>
										<img src="{{url('admin/images/QQ.png')}}"  class="qqImg"/>
										<label class="tela">1702688880</label>
									</div></td>
							</tr>
							<tr>
								<td colspan="5" class="lee tdn tdn1"> {{--<label class="fz fz1 fl">自营物流单号：{{ $date[$k] ->name }}</label>--}} 
									<label class="fz  fz1 fphone">收货人：{{ $date[$k] ->name }}</label>
									<label class="fz  fz1 ">收货人电话：{{ $date[$k] -> phone }}</label>
									<label class="fz  fz1 fr">[{{ count($data2[$k]) }}/{{ $keys+1 }}]</label>
									</td>
							</tr>
							<tr id="address">
								<td colspan="5" class="lee tdn tdn1">
									<label class="col-4 fz fl">快递名称： <span id="name"  type="text" class="fz">{{ $date[$k] -> shipping_name }}</span> </label>
									<label  class="col-3 fz fl">快递单号： <span id="code"  type="text" class="fz" >{{ $date[$k] -> shipping_code }}</span> </label>
									<p  class="col-5 fz fl">收货地址： <span id="code"  type="text" class="fz">{{ $date[$k] -> address }}</span> </p></td>

							</tr >
							<tr id="goods">
								<th>商品名称</th>
								<!-- <th>规格</th> -->
								<th>数量</th>
								<th>单位</th>
								<th>优惠金额</th>
								<th>客户备注</th>
							</tr>
						</thead>
						<tbody>
							@foreach($value as $ka => $v)
							<tr class="goods">
								<td>{{ $v -> pname }}</td>
								<!-- <td>121</td> -->
								<td>{{ $v -> num }}</td>
								<td>{{ $v -> unit }}</td>
								<td>{{ $v -> dis_count }}</td>
								<td>{{ $v -> user_note }}</td>
							</tr>
							@endforeach

						</tbody>
					</table>

				</div>
				<div class="foot">
					<div  style="border:none;">
						<td colspan="4" class="lee tdn "><label class="fz">商品合计：{{ $date[$k] -> pay_amount }}</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <label class="fz">付款时间：{{ $date[$k] -> addtime }}</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <label class="fz">支付方式：@if($date[$k] -> pay_name == 0 )支付宝@elseif($date[$k] -> pay_name == 1)余额@elseif($date[$k] -> pay_name == 2)微信@endif</label></td>
						<td  rowspan="2" class="tdn tdn1">
							<img src="{{url('admin/images/ma.jpg')}}"  class="logoImg" style="float:right;"/>
						</td>
					</div>

					<div>
						<td style="width: 100%;" class="lee tdn"><label class="fz fl">备注：</label><label class="fz fr pad">客户签字：</label></td>
					
					</div>
				</div>
			</div>
		</div>
		@else
		{{--//需要隐藏logo--}}
		<div class="allWid " id="allWid" style="position:relative;top: {{(($loop ->index)+($loop ->parent ->index))*(-8)}}px;">
			
			<div  id="printArea" class="printArea"  >
				<div>
					<table id="tabb" border="1" cellspacing="0" cellpadding="0" >
						<thead>
							<tr>
								<td colspan="5" class="lee tdn tdn1"> {{--<label class="fz fz1 fl">自营物流单号：{{ $date[$k] ->name }}</label>--}} 
									<label class="fz  fz1 fphone">收货人：{{ $date[$k] ->name }}</label>
									<label class="fz  fz1 ">收货人电话：{{ $date[$k] -> phone }}</label>
									<label class="fz  fz1 fr">[{{ count($data2[$k]) }}/{{ $keys+1 }}]</label>
									</td>
							</tr>
							<tr id="address">
								<td colspan="5" class="lee tdn tdn1">
									<label class="col-4 fz fl">快递名称： <span id="name"  type="text" class="fz">{{ $date[$k] -> shipping_name }}</span> </label>
									<label  class="col-3 fz fl">快递单号： <span id="code"  type="text" class="fz" >{{ $date[$k] -> shipping_code }}</span> </label>
									<p  class="col-5 fz fl">收货地址： <span id="code"  type="text" class="fz">{{ $date[$k] -> address }}</span> </p></td>
									

							</tr >
							<tr id="goods">
								<th>商品名称</th>
								<!-- <th>规格</th> -->
								<th>数量</th>
								<th>单位</th>
								<th>优惠金额</th>
								<th>备注</th>
							</tr>
						</thead>
						<tbody>
							@foreach($value as $ka => $v)
							<tr class="goods">
								<td>{{ $v -> pname }}</td>
								<!-- <td>121</td> -->
								<td>{{ $v -> num }}</td>
								<td>{{ $v -> unit }}</td>
								<td>{{ $v -> dis_count }}</td>
								<td>{{ $v -> user_note }}</td>
							</tr>
							@endforeach
							
						</tbody>
					</table>

				</div>
				
				<div class="foot">
					<div  style="border:none;">
						<td colspan="4" class="lee tdn "><label class="fz">商品合计：{{ $date[$k] -> pay_amount }}</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <label class="fz">付款时间：{{ $date[$k] -> addtime }}</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <label class="fz">支付方式：@if($date[$k] -> pay_name == 0 )支付宝@elseif($date[$k] -> pay_name == 1)余额@elseif($date[$k] -> pay_name == 2)微信@endif</label></td>
						<td  rowspan="2" class="tdn tdn1">
							<img src="{{url('admin/images/ma.jpg')}}"  class="logoImg" style="float:right;"/>
						</td>
					</div>

					<div>
						<td style="width: 100%;" class="lee tdn"><label class="fz fl">备注：</label><label class="fz fr pad">客户签字：</label></td>
						
					</div>
				</div>
			</div>
		</div>
		@endif
		@endif
		@endforeach
		@endif
		@endforeach
		<script src="{{ asset('admin/components/jquery/dist/jquery.min.js') }}"></script>
		<script src="{{ asset('admin/jquery.jqprint-0.3.js') }}"></script>
		<script src="{{ asset('admin/jquery-migrate-1.1.0.js') }}"></script>
		<script src="{{ asset('admin/myjs/order/logistic.js') }}"></script>
		<script>//  var libUrl= "{{ url('admin/order/lib') }}";
//  var Heig=$("#allWid ").height();
//  var Hd=330;
//  var abc = Math.ceil(Heig/Hd);
//  // console.log(Heig);
//  if(Heig<=Hd){
//    $('#allWid').css("height","330px");
// // $('#tabb').css("height","320px");
//  }
//  else{
//    var tHeight = Hd*abc+(abc-1)*20;
//    $('#allWid').css("height",tHeight);
//  }
//  // console.log(tHeight);</script>
		<script src="{{ asset('admin/jquery.number.js') }}"></script>
</HTML>
