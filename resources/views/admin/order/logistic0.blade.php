@extends('admin.common.base')
@section('css')
<link rel="stylesheet" href="{{ asset('admin/mycss/common/alertwords.css') }}" />
<link rel="stylesheet" href="{{ asset('admin/print.css') }}"  type="text/css" media="print"/>
<!-- <link rel="stylesheet" href="{{ asset('admin/assets/css/bootstrap.css') }}"  type="text/css" media="print"/> -->
<link rel="stylesheet" href="{{ asset('admin/assets/css/ace.css') }}"  type="text/css" media="print"/>
<link rel="stylesheet" href="{{ asset('admin/assets/css/bootstrap.css') }}"  type="text/css" media="print"/>
<link rel="stylesheet" href="{{ asset('admin/mycss/order/logistic.css') }}" />
@endsection
@section('first_title','首页')
@section('second_title','出库单')
@section('content')
<div class="page-header">
  <h1>
    出库单
    <small>
      <a href="javascript:" onclick="self.location=document.referrer;">
        <button class="btn btn-xs return btn-info" style="float:right">
          返回
        </button>
      </a>
    </small>
  </h1>
</div><!-- /.page-header -->
<div>
  <h3>出库前请注意填写物流名称和单号，不填写默认为自营物流</h3>
  <div id=“printH” style="width:580px" >
    <div class="div2"  id="printArea" >
      <label class="lab1">日期:</label></br>
      <img src="{{url('admin/images/chuhuo.jpg')}}" id="logoImg"/>
      <div >
        <div class="personInfo">
          <input id="name" type="text" placeholder="自营物流"  style="font-size:20px" name="name" value="{{ $data-> shipping_name }}" />
          <input id="code" type="text" placeholder="输入物流单号"  style="font-size:20px" name="code" value="{{ $data-> shipping_code }}" />
          <label class="lab1">&nbsp;收货人：{{ $data -> name }}</label></br>
          <label class="lab1">&nbsp;收货人电话：18888888888</label></br>
        <label class="lab1">&nbsp;收货地址：{{ $data -> address }}</label>
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
  						<td>{{ $data -> pname }}</td>
              <td>{{ $data -> num }}</td>
  						<td>{{ $data -> unit }}</td>
  						<td>{{ $data -> dis_count }}</td>
  						<td>{{ $data -> logis }}</td>
            </tr>
            <tr>
              <td colspan="6" style="text-align:left">
                <label class="lab2">商品合计：{{ $data -> order_amount }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;付款时间：{{ $data -> addtime }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 付款方式：@if($data -> pay_name == 0 ) 支付宝
  							@elseif($data -> pay_name == 1) 余额
  							@elseif($data -> pay_name == 2) 微信
  							@endif
  						</label></br>
                <label class="lab2">温馨提示：{{ $data -> user_note }}</label>
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
  <button class="btn btn-xs btn-success lib butt" id="timccc">自动生成订单号</button>
  @if($data -> order_status == 2)
  <button class="btn btn-xs btn-warning lib butt"  onclick="return libid({{ $data -> id }}) ">出库 </button>
  @endif
  <button class="btn btn-xs btn-info lib butt" id="btnPrint" >打印订单 </button>
  @if($data -> order_status == 0)
  <button class="btn btn-xs btn-success lib butt" data-toggle="modal" data-target=".bs-example-modal-sm">修改价格 </button>
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
            <span>修改运费价格：</span><input type="text" onkeyup="if( ! /^\d+(?:.\d{0,2})?$/.test(this.value)){this.value='';}" class="num"  name="number" value="" max="999"><br></br>
            <span>修改优惠价格：</span><input type="text" onkeyup="if( ! /^\d+(?:.\d{0,2})?$/.test(this.value)){this.value='';}" class="num"  name="number" value="">
            <input type="hidden" name="id" value="{{ $data -> id }}">    </div>
            <div class="modal-footer">
              <button	 type="submit" class="btn btn-sm btn-success">确定</button>
              <a href="#" class="btn btn-sm" data-dismiss="modal">关闭</a>
            </div>
          </div>
        </div>
      </div>
    </form>
    @endsection
    @section('js')
    <script src="{{ asset('admin/components/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('admin/jquery.jqprint-0.3.js') }}"></script>
    <script src="{{ asset('admin/jquery-migrate-1.1.0.js') }}"></script>
    <script src="{{ asset('admin/myjs/order/logistic.js') }}"></script>
    <script>
    var libUrl= "{{ url('admin/order/lib') }}";
    //  $(function(){
    //     //  console.log("print",$('#printArea').css('height'));
    //     $('#logoImg').css("width",$('#printArea').css('width'));
    //  })
    </script>
     <script src="{{ asset('admin/jquery.number.js') }}"></script>


     @endsection
