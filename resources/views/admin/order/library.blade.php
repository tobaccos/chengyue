@extends('admin.common.base')
@section('css')
<link rel="stylesheet" href="{{ asset('admin/mycss/common/alertwords.css') }}" />
<link rel="stylesheet" href="{{ asset('admin/mycss/order/library.css') }}" />
@endsection
@section('first_title','订单管理')
@section('second_title','批量出库')
@section('content')
<div class="page-header">

  <h1>
    <small>
      <!-- <a href="{{ url('admin/order/orderList') }}"> -->
      <a href="javascript:" onclick="self.location=document.referrer;">
				<button class="btn btn-xs return btn-info" style="float:right">
            返回
          </button>
        </a>
      </small>
    </h1>
  </div><!-- /.page-header -->
<div class="row">
	<div class="col-xs-12">
    <form class="form-horizontal"  action="{{ url('admin/order/batchLibrary') }}" method="post" >
        {{ csrf_field() }}
      <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 下单时间 </label>
        <div class="col-sm-9" >
					<div class=" col-xs-10 col-sm-10">
          <div class="input-daterange input-group col-xs-10 col-sm-5">
            <input type="text" class="input-sm form-control" placeholder="请选择下单时间" name="start" id="start" required/>
            <span class="input-group-addon">
              <i class="fa fa-exchange"></i>
            </span>
            <input type="text" class="input-sm form-control" placeholder="请选择下单时间" name="end" id="end" required/>
          </div>
				</div>
          <!-- /section:plugins/date-time.datepicker -->
        </div>
      </div>

			<div class="space-4"></div>
			<div data-toggle="distpicker">
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 收货地址 </label>
                    <div class="col-sm-9" >
                        <div class=" col-xs-10 col-sm-2">
                            <select class="input-sm form-control" id="province2" data-province="---- 选择省 ----" name="address1" value=""></select>
                        </div>
                        <div class=" col-xs-10 col-sm-2">
                            <select class="input-sm form-control" id="city2" data-city="---- 选择市 ----" name="address2" value=""></select>
                        </div>
                        <div class=" col-xs-10 col-sm-2">
                            <select class="input-sm form-control" id="district2" data-district="---- 选择区 ----" name="address3" value=""></select>
                        </div>
                    </div>
                </div>
			</div>
			<div class="space-4"></div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-2" > 物流名称 </label>
                <div class="col-sm-9">
                    <div class=" col-xs-10 col-sm-9">
                        <input type="text" class="col-xs-10 col-sm-5" name="shipping_name" value="" maxlength="20" required="required">
                        <!-- <button type="button" class="btn btn-success btn-sm" >匹配送货人</button> -->
                     </div>
                </div>
            </div>
      <div class="space-4"></div>
      <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 物流单号 </label>
        <div class="col-sm-9">
					<div class=" col-xs-10 col-sm-9">
          <input type="text" id="timcc" placeholder="输入物流单号" class="col-xs-10 col-sm-5" name="shipping_code"required value=""/>
          <button type="button" class="btn btn-success btn-sm" id="timccc">自动生成</button>
        </div>
				</div>
      </div>
      <div class="space-4"></div>
      <div class="clearfix form-actions" >
        <div class="col-md-offset-4 col-md-8">
          <button type="submit" class="btn btn-success btn-sm" >出库</button>
          <button type="reset" onclick="javascript:history.go(-0 )" class="btn btn-info btn-sm" >取消</button>
        </div>
      </div>
    </form>
  </div>
  <table class="table" id="tab">
    <tbody>
      <tr class="info">
        <td>订单编号</td>
        <td>用户</td>
        <td>下单时间</td>
        <td>商品</td>
        <td>订单商品数</td>
        <td>优惠金额</td>
        <td>优惠金额</td>
        <td>当前状态</td>
        <td>运费</td>
        <td>总金额</td>
        <td>实付款</td>
      </tr>
    </tbody>
  </table>
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
<script src="{{ asset('admin/myjs/order/library.js') }}"></script>
<script src="{{ asset('admin/components/bootstrap/dist/js/bootstrap.js') }}"></script>
<script src="{{ asset('admin/components/address3/js/distpicker.data.js') }}"></script>
<script src="{{ asset('admin/components/address3/js/main.js') }}"></script>
<script src="{{ asset('admin/components/address3/js/distpicker.js') }}"></script>
@endsection
