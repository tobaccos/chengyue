@extends('admin.common.base')
@section('css')
<link rel="stylesheet" href="{{ asset('admin/mycss/common/alertwords.css') }}" />
<link rel="stylesheet" href="{{ asset('admin/mycss/user/userClass.css') }}" />
<link rel="stylesheet" href="{{ asset('admin/mycss/test.css') }}" />
@endsection
@section('first_title','用户管理')
@section('second_title','修改用户类型')
@section('content')
<div class="page-header">
  <h1>
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
<div class="row">
  <div class="col-xs-12">
    <form class="form-horizontal" role="form" action="{{url('admin/user/userclass/update')}}/{{$data -> id}}" method="post">
      {{ csrf_field() }}
      <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 类型名称 </label>
        <div class="col-sm-9">
          <input type="text" id="tname" placeholder="输入分类名称（20字符以内）" maxlength="20" class="col-xs-10 col-sm-5" name="name" value="{{$data -> name}}"/>
          <label class="  col-sm-3 control-label no-padding-right" ></label>
          <div class="col-sm-9 setInfo">
            <p class="spa spa14"></p>
          </div>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 开通金额（月）</label>
				<div class="col-sm-9">
					<input type="number" min="0" max="10000" step="0.01"  placeholder="请输入开通一个月的金额" class="col-xs-10 col-sm-5" id="pt" name="month_money" value="{{$data -> month_money}}" />
          <label class="  col-sm-3 control-label no-padding-right" ></label>
          <div class="col-sm-9 setInfo">
            <p class="spa spa15"></p>
          </div>
				</div>
			</div>
      <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 开通金额（年）</label>
        <div class="col-sm-9">
					<input type="number" min="0" max="10000" step="0.01"  placeholder="请输入开通一年的金额" class="col-xs-10 col-sm-5" id="py" name="year_money" value="{{$data -> year_money}}" />
          <label class="  col-sm-3 control-label no-padding-right" ></label>
          <div class="col-sm-9 setInfo">
            <p class="spa spa16"></p>
          </div>
				</div>
			</div>
      <input type="hidden" name="created_at" value="{{$data -> created_at}}">
			<div class="clearfix form-actions" >
				<div class="col-md-offset-4 col-md-9">
          <button class="btn btn-info" type="submit" id="tsub">
            <i class="icon-ok bigger-110"></i>
            确定
					</button>
          &nbsp; &nbsp; &nbsp;
					<button class="btn" type="reset">
						<i class="icon-undo bigger-110"></i>
						取消
					</button>
				</div>
			</div>
    </form>
  </div>
</div>
@endsection
@section('js')
<script src="{{ asset('admin/components/jquery/dist/jquery.js') }}"></script>
<script src="{{ asset('admin/components/jquery.1x/dist/jquery.js') }}"></script>
<script src="{{ asset('admin/myjs/test.js') }}"></script>

@endsection
