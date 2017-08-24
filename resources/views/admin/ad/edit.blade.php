@extends('admin.common.base')
@section('css')
    <link rel="stylesheet" href="{{ asset('admin/mycss/common/alertwords.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/mycss/ad/list.css') }}" />
@endsection
@section('first_title','广告管理')
@section('second_title','广告列表')
@section('content')
    <a  href="javascript:" onclick="self.location=document.referrer;">
        <button class="btn btn-xs return btn-info" id="returnBtn">
            返回
        </button>
    </a>
    <div class="row">
        <div class="col-xs-12">
            <form class="form-horizontal" role="form" id="addForm" action="" method="post" enctype="multipart/form-data">
				<input type="hidden" name="id" value="{{isset($data['id'])?$data['id']:''}}">
                {{csrf_field()}}
				<div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" >广告位置</label>
                    <div class="col-sm-9">
                        <select name="position" class="no-left">
						@foreach($posData as $pos)
							@if(isset($data['position']))
								@if($data['position'] == $pos['id'])
							<option value="{{$pos['id']}}" selected>{{$pos['title']}}</option>
								@else
							<option value="{{$pos['id']}}">{{$pos['title']}}</option>
								@endif
							@else
							<option value="{{$pos['id']}}">{{$pos['title']}}</option>
							@endif
						@endforeach
						</select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" >广告名称</label>
                    <div class="col-sm-9">
                        <input type="text" id="title" name="title" placeholder="请输入广告名称"  class="col-xs-10 col-sm-5"  value="{{isset($data['title'])?$data['title']:''}}" maxlength="10" required/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" >广告图片 </label>
                    <div class="col-sm-9">
                        <input id="file_upload1" name="file_thumbing" type="file" value="{{isset($data['pic'])?$data['pic']:''}}" multiple="true">
                        @if(isset($data['pic']) && !empty($data['pic']))
                            <img id="art_thumb_img" src="{!! AD_IMG_PATH . $data['pic'] !!}" >
                            <input type="hidden" name="pic" value="{!!$data['pic']!!}">
                        @else
                            <img id="art_thumb_img" src="{{ url('admin/images/no.png') }}" >
                            <input type="hidden" name="pic" value="">
                        @endif

                    </div>
                </div>
				<div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" >广告链接</label>
                    <div class="col-sm-9">
                        <input type="text" id="url" name="url" placeholder="http:// 为空则不加链接"  class="col-xs-10 col-sm-5" value="{{isset($data['url'])?$data['url']:''}}"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" >状态</label>
                    <div class="col-sm-9">
                        <div class="radio">
                            @if(isset($data['state']))
                            <label>
                                <input name="state" type="radio" {{$data['state'] == 1 ? 'checked':''}} class="ace" value="1" />
                                <span class="lbl">正常</span>
                            </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                            <label>
                                <input name="state" type="radio" {{$data['state'] == 0 ? 'checked':''}} class="ace" value="0" />
                                <span class="lbl"> 禁用</span>
                            </label>
                             @else
                                <label>
                                    <input name="state" type="radio" checked class="ace" value="1" />
                                    <span class="lbl">正常</span>
                                </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                <label>
                                    <input name="state" type="radio" class="ace" value="0" />
                                    <span class="lbl"> 禁用</span>
                                </label>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="clearfix form-actions">
                    <div class="col-md-offset-5 col-md-9">
                        <button class="btn btn-info" type="submit">
                            <i class="ace-icon fa fa-check bigger-110"></i>
                            提交
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{asset('admin/components/uploadify/jquery.uploadify.min.js')}}" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="{{asset('admin/components/uploadify/uploadify.css')}}">
    <script>
        var token="{{csrf_token()}}";
        var swf="{{asset('admin/components/uploadify/uploadify.swf')}}";
        var uploader="{{url('admin/pro/uploadify/3')}}";
    </script>
    <script src="{{asset('admin/myjs/promanage/singleImg.js')}}" type="text/javascript"></script>
    {{--表单验证插件--}}
    <script src="{{ asset('common/jqueryval/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('common/jqueryval/dist/localization/messages_zh.js') }}"></script>
    <script>
        $("#addForm").validate({
            rules: {
                title: {
                    maxlength:15,
                    required: true,
                }
            },
            messages:{
                title: {
                    required: "广告名称不能为空，请输入！",
                }
            }
        });
    </script>
@endsection
