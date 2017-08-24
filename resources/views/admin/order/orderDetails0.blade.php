<HTML>
<head>
<script  language="javascript" type="text/javascript">

function printwithoutsetup(){
 var a;
 a=document.getElementById("TestAX");
 var btn = document.getElementById('prin1');
 a.Mar_left=0.0075;
 a.Mar_Top=0.0075;
 a.Mar_Right=0.0075;
 a.Mar_Bottom=0.0075;
 a.Orientation="横向";
 a.Paper_Size="Folio";
 a.Header_Html="Headeraaaaaaaa";
 a.Footer_Html="Footerssssssss";
 btn.style.display="none";
 a.ApplySetup();
 a.PrintWithOutSetup();
}
function preview(){
 var a;
 var btn = document.getElementById('prin1');
 a=document.getElementById("TestAX");
 a.Mar_left=3.5;
 a.Mar_Top=0.0075;
 a.Mar_Right=0.0075;
 a.Mar_Bottom=0.0075;
 a.Orientation="向";
 a.Paper_Size="A0";
 a.Header_Html="Headeraaaaaaaa";
 a.Footer_Html="Footerssssssss";
 btn.style.display="none";
 a.ApplySetup();
 a.PrintPreView();

}
function printwithsetup(){
 var a;
 a=document.getElementById("TestAX");
 var btn = document.getElementById('prin1');
 a.Mar_left=0.0075;
 a.Mar_Top=0.0075;
 a.Mar_Right=0.0075;
 a.Mar_Bottom=0.0075;
 a.Orientation="向";
 a.Paper_Size="A4";
 a.Header_Html="Headeraaaaaaaa";
 a.Footer_Html="Footerssssssss";
 btn.style.display="none";
 a.PrintWithSetup();
}
function printwithoutsetup2(){
 var a;
 var b;
 a=document.getElementById("TestAX");
 var btn = document.getElementById('prin1');
 a.Mar_left=0.0075;
 a.Mar_Top=0.0075;
 a.Mar_Right=0.0075;
 a.Mar_Bottom=0.0075;
 a.Orientation="横向";
 a.Paper_Size="Folio";
 a.Header_Html="Headeraaaaaaaa";
 a.Footer_Html="Footerssssssss";
 btn.style.display="none";
 a.ApplySetup();
 a.PrintWithOutSetupPrintByID("163");
}
function printwithoutsetup3(){
 var a;
 var b;
 a=document.getElementById("TestAX");
 var btn = document.getElementById('prin1');
 a.Mar_left=0.0075;
 a.Mar_Top=0.0075;
 a.Mar_Right=0.0075;
 a.Mar_Bottom=0.0075;
 a.Orientation="纵向";
 a.Paper_Size="Folio";
 a.Header_Html="Headeraaaaaaaa";
 a.Footer_Html="Footerssssssss";
 btn.style.display="none";
 a.ApplySetup();
 a.PrintWithOutSetupPrintWithOutByID("cnnb");
}
function printwithoutsetup4(){
 var a;
 var b;
 a=document.getElementById("TestAX");
 var btn = document.getElementById('prin1');
 a.Mar_left=0.0075;
 a.Mar_Top=0.0075;
 a.Mar_Right=0.0075;
 a.Mar_Bottom=0.0075;
 a.Orientation="纵向";
 a.Paper_Size="Folio";
 a.Header_Html="Headeraaaaaaaa";
 a.Footer_Html="Footerssssssss";
 a.Form_Width=100;
 a.Form_Height=200;
 a.Caption="我来测试";
 a.Color=1234123;
 btn.style.display="none";
 a.ApplySetup();
 a.PrintWithOutSetup();
}

</script>
	<meta charset="UTF-8">
	<title>Document</title>
<link rel="stylesheet" href="{{ asset('admin/mycss/common/alertwords.css') }}" />
<link rel="stylesheet" href="{{ asset('admin/print.css') }}"  type="text/css" media="print"/>
<link rel="stylesheet" href="{{ asset('admin/assets/css/bootstrap.css') }}"  type="text/css" />
<link rel="stylesheet" href="{{ asset('admin/assets/css/ace.css') }}"  type="text/css"/>
<link rel="stylesheet" href="{{ asset('admin/mycss/order/logistic.css') }}" />
<style type="text/css">
label{
	font-size: 20px !important;
	margin-top: 5px;
}
.inpw{
	font-size: 20px !important;
}
</style>
</head>
<body style="text-align: -webkit-center;">
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
@foreach($data as $value)
@foreach($value as $v)
<div id=“printH” style="width:580px;" >
  <div class="div2"  id="printArea" >
    <label class="lab1" >日期:</label></br>
    <img src="{{url('admin/images/chuhuo.jpg')}}" id="logoImg"/>
    <div >
      <div class="personInfo">
        <input id="name" type="text" placeholder="自营物流"  style="font-size:20px" name="name" value="{{ $v-> shipping_name }}" />
        <input id="code" type="text" placeholder="输入物流单号"  style="font-size:20px" name="code" value="{{ $v-> shipping_code }}" />
        <label class="lab1">&nbsp;收货人：{{ $v -> name }}</label></br>
        <label class="lab1">&nbsp;收货人电话：18888888888</label></br>
      <label class="lab1">&nbsp;收货地址：{{ $v -> address }}</label>
    </div>

  				<div class="div3">

				</div>

        <table class="table" border="1" cellspacing="0" cellpadding="0" id="biaoge" >
          <thead>
            <tr style="background:#fff;color:#000000">
              <th>商品名称</th>
              <th>数量</th>
              <th>单位</th>
              <th>优惠金额</th>
              <th>运费</th>
            </tr>
            </thead>
            <tbody>
              <tr>
						<td>{{ $v -> pname }}</td>
						<td>{{ $v -> num }}</td>
            <td>单位</td>
						<td>{{ $v -> dis_count }}</td>
						<td>{{ $v -> logis }}</td>
          </tr>
          <tr>
            <td colspan="6" style="text-align:left">
              <label class="lab2">商品合计：{{ $v -> order_amount }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;付款时间：{{ $v -> addtime }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <label class="lab2">付款方式：@if($v -> pay_name == 0 ) 支付宝
                @elseif($v -> pay_name == 1) 余额
                @elseif($v -> pay_name == 2) 微信
                @endif
              </label></br>
              <label class="lab2">温馨提示：{{ $v -> user_note }}</label>
           </td>
          </tr>
          <tr>
            <td>备注</td>
              <td colspan="5"></td>
          </tr>
          </tbody>
        </table >
      </div>
    </div>
  </div>
@endforeach
@endforeach
</body>
<script src="{{ asset('admin/components/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('admin/jquery.jqprint-0.3.js') }}"></script>
<script src="{{ asset('admin/jquery-migrate-1.1.0.js') }}"></script>
<script src="{{ asset('admin/myjs/order/logistic.js') }}"></script>
<script>
	var libUrl= "{{ url('admin/order/lib') }}";
</script>
<script src="{{ asset('admin/jquery.number.js') }}"></script>
</HTML>
