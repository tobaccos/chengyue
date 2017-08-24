@extends('admin.common.base')
@section('css')
<link rel="stylesheet" href="{{ asset('admin/mycss/common/alertwords.css') }}" />
<link rel="stylesheet" href="{{ asset('admin/mycss/partner/add.css') }}" />
<link rel="stylesheet" href="{{ asset('admin/mycss/test.css') }}" />
@endsection
@section('first_title','合作商家管理')
@section('second_title','修改商家')
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
    <!-- PAGE CONTENT BEGINS -->
    <form class="form-horizontal" role="form" action="{{ url('admin/partner/update') }}/{{$data ->id}}" method="post" enctype="multipart/form-data">
			{{ csrf_field() }}
			{{--<div class="form-group">--}}
				{{--<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 编号 </label>--}}

				{{--<div class="col-sm-9">--}}
					{{--<input type="text" id="form-field-1" placeholder="ID" class="col-xs-10 col-sm-5" />--}}
				{{--</div>--}}
			{{--</div>--}}
      <div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 名称 </label>

				<div class="col-sm-9">
					<input type="text"  placeholder="名称" maxlength="20" id="parname" class="col-xs-10 col-sm-5" name="name" value="{{ $data -> name }}" />
          <label class="  col-sm-3 control-label no-padding-right" ></label>
          <div class="col-sm-9 setInfo">
            <p class="spa spa8"></p>
        </div>
				</div>
			</div>
			  {{--<div class="form-group">--}}
				{{--<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 记录人 </label>--}}

				{{--<div class="col-sm-9">--}}
				  {{--<input type="text" id="form-field-1" placeholder="记录人" class="col-xs-10 col-sm-5" />--}}
				{{--</div>--}}
                  {{--</div>--}}

				<div class="space-4"></div>

				{{--<div class="form-group">--}}
					{{--<label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 记录时间 </label>--}}

					{{--<div class="col-sm-9">--}}
						{{--<input type="password" placeholder="记录时间" class="col-xs-10 col-sm-5" />--}}
					{{--</div>--}}
				{{--</div>--}}

			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 商家LOGO </label>

        <div id="preview" class="col-sm-9 uplode"  >
          <img id="imghead" width=250px   border=0  class="butup" src="{{ url('/uploads/product/cate') }}/{{ $data -> pic }}">
        </div>
        <!-- <input type="file" onchange="previewImage(this)" class="col-xs-10 col-sm-5 " name="pic" value=""/> -->
      </div>
      <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-2">  </label>

        <div class="col-sm-9">
          <input type="file" onchange="previewImage(this)" class="col-xs-10 col-sm-5" name="pic" value="{{ $data -> pic }}" />

        </div>
      </div>

			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 跳转地址 </label>

				<div class="col-sm-9">
					<input type="text" placeholder="跳转地址" class="col-xs-10 col-sm-5"  maxlength="40" name="url" id="urlll" value="{{ $data -> url }}"/>
          <label class="  col-sm-3 control-label no-padding-right" ></label>
          <div class="col-sm-9 setInfo">
            <p class="spa spa7"></p>
          </div>
				</div>
			</div>

				<div class="space-4"></div>

				<div class="clearfix form-actions" >
					<div class="col-md-offset-3 col-md-9">
						<button class="btn btn-info" type="submit" id="psub">
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
    <script src="{{ asset('admin/myjs/partner/add.js') }}"></script>
<script src="{{ asset('admin/myjs/test.js') }}"></script>
@endsection
