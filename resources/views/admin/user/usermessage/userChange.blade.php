@extends('admin.common.base')
@section('css')
<link rel="stylesheet" href="{{ asset('admin/mycss/common/alertwords.css') }}" />
<link rel="stylesheet" href="{{ asset('admin/mycss/user/userChange.css') }}" />
<link rel="stylesheet" href="{{ asset('admin/mycss/user/userChange1.css') }}" />
<link rel="stylesheet" href="{{ asset('admin/mycss/test.css') }}" />
@endsection
@section('first_title','用户管理')
@section('second_title','修改用户信息')
@section('content')
<div class="page-header">
  <h1>
    <small>
     <a href="javascript:" onclick="self.location=document.referrer;">
        <button class="btn btn-xs return btn-info" style="float:right">
            返回
          </button>
        </a>
    </small>
  </h1>
</div>
<div class="row">
  <!--<div class="col-xs-12">
    <div  class=""id="info">
      @if(session('info'))
      <div class="callout callout-success">
        <p>{{session('info')}}</p>
      </div>
      @endif
    </div>-->
    <form class="form-horizontal" role="form" action="{{ url('admin/user/usermessage/update') }}/{{ $data[0]-> id }}" method="post">
      {{ csrf_field() }}
      <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" id="name" >用户昵称</label>
        <div class="col-sm-9">
          <input type="text" placeholder="用户昵称" maxlength="20" id="username" class="col-xs-7 col-sm-5" name="name" value="{{ $data[0] -> name }}" />
          <label class="  col-sm-3 control-label no-padding-right" ></label>
          <div class="col-sm-9 setInfo">
            <p class="spa spa1"></p>
          </div>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 用户状态 </label>
        <div class="col-sm-9">
          <div class="radio">
            <label>
              <input name="state" type="radio" class="ace"  value="0"  @if($data[0]-> state == 0) checked @endif />
              <span class="lbl">启用</span>
            </label>
            <label>
              <input name="state" type="radio" class="ace" value="1"   @if($data[0]-> state == 1) checked @endif/>
              <span class="lbl">禁用</span>
            </label>
          </div>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 用户类型 </label>
        <div class="col-sm-9">
          <select class="col-xs-7 col-sm-5" id="form-field-select-3"  data-placeholder="" name="tid">
            <option value=" {{$data[0] -> tid}} "> {{ $data[0] -> tname }} </option>
            @foreach($tdata as $k => $v)
            <option name="user_type" value="{{ $v -> id }}">{{ $v -> name  }}</option>
            @endforeach
          </select>
        </div>
      </div>
      <!-- <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1" id="passw"> 重置密码 </label>
        <div class="col-sm-9">
          <input type="text" placeholder="重置密码" class="col-xs-7 col-sm-5" id="passw"  maxlength="20" name="password" value="" />
        </div>
      </div> -->
    <div class="form-group">
      <label class="col-sm-3 control-label no-padding-right" for="form-field-1" id="mail"> 邮箱 </label>
      <div class="col-sm-9">
        <input type="text" placeholder="邮箱" class="col-xs-7 col-sm-5" id="email"  maxlength="32" name="email" value="{{ $data[0] -> email }}" />
        <label class="  col-sm-3 control-label no-padding-right" ></label>
        <div class="col-sm-9 setInfo">
          <p class="spa spa5"></p>
        </div>
      </div>
    </div>
    <div class="space-4"></div>
    <div class="form-group">
      <label class="col-sm-3 control-label no-padding-right" for="form-field-2" id="qq1"> QQ </label>
      <div class="col-sm-9">
        <input type="text" placeholder="QQ" class="col-xs-7 col-sm-5" id="QQ"  maxlength="10" name="QQ" value="{{ $data[0] -> QQ }}" />
        <label class="  col-sm-3 control-label no-padding-right" ></label>
        <div class="col-sm-9 setInfo">
          <p class="spa spa6"></p>
        </div>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-3 control-label no-padding-right" id="phone" for="form-field-2"> 电话 </label>
      <div class="col-sm-9">
        <input type="tel" placeholder="请输入11位手机号码" name="userphone" id="userphone"  maxlength="11" class="col-xs-7 col-sm-5" value="{{ $data[0] -> phone }}" />
        <label class="  col-sm-3 control-label no-padding-right" ></label>
        <div class="col-sm-9 setInfo">
          <p class="spa spa2"></p>
        </div>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 是否为代理商 </label>
      <div class="col-sm-9">
          <input type="text" class="col-xs-7 col-sm-5" disabled value="@if($data[0] -> dls_apply == 2) 是 @else 否 @endif">
      </div>
    </div>
    <div class="space-4"></div>
    <div class="clearfix form-actions" >
      <div class="col-md-offset-4 col-md-7">
        <!-- <input type="submit" class="btn btn-info" name="" value="确定" id="sub1"> -->

        <button class="btn btn-info" type="submit" id="sub">
          确定
        </button>
        <!-- <i class="icon-ok bigger-110"></i> -->
        &nbsp; &nbsp; &nbsp;
        <button class="btn" type="reset">
          <i class="icon-undo bigger-110"></i>
          取消
        </button>
      </div>
    </div>
  </form>
</div>
@endsection
@section('js')
<script src="{{ asset('admin/components/jquery/dist/jquery.js') }}"></script>
<script src="{{ asset('admin/components/jquery.1x/dist/jquery.js') }}"></script>
<!-- <script src="{{ asset('admin/myjs/user/userDetail.js') }}"></script> -->
<script src="{{ asset('admin/myjs/test.js') }}"></script>
@endsection
