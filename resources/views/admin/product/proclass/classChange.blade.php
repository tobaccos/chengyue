@extends('admin.common.base')
@section('css')
    <link rel="stylesheet" href="{{ asset('admin/mycss/common/alertwords.css') }}" />
    <style>
        #product .submenu{
            display:block;
        }
        #product>a{
            color:#5999D0;
        }
        .error{
            padding-top:6px;
            padding-left:5px;
            font-size:10px;
            color:red;
        }
    </style>
@endsection
@section('first_title','产品管理')
@section('second_title','产品分类')
@section('content')

    <div class="row">
        <div class="col-xs-12">
            <form class="form-horizontal" role="form" id="addForm" action="{{isset($data['id'])?url('admin/category/'.$data['id']):url('admin/category')}}" method="post" enctype="multipart/form-data">
			@if(isset($data['id']))
                    <input type="hidden" name="_method" value="put">
            @endif
                {{csrf_field()}}
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" >分类名称</label>
                    <div class="col-sm-9">
                        <input type="text" id="myname" name="name"  required placeholder="请输入分类名称"  class="col-xs-10 col-sm-5" value="{{isset($data['name'])?$data['name']:''}}"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" >分类图片 </label>
                    <div class="col-sm-9">
                        <input id="file_upload1" name="file_thumbing" type="file" name="pic" value="{{isset($data['pic'])?$data['pic']:''}}" multiple="true">
                        @if(isset($data['pic']) && !empty($data['pic']))
                            <img id="art_thumb_img" src="{!! PRO_CATE_IMG_PATH . $data['pic'] !!}" style="width:100px;">
                            <input type="hidden" name="pic" value="{!!$data['pic']!!}">
                        @else
                            <img id="art_thumb_img" src="{{ url('admin/images/no.png') }}"  >
                            <input type="hidden" name="pic" value="">
                        @endif

                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" >状态</label>
                    <div class="col-sm-9">
                        <div class="radio">
                            @if(isset($data['state']))
                            <label>
                                <input name="state" type="radio" {{$data['state'] == 0 ? 'checked':''}} class="ace" value="0" />
                                <span class="lbl">正常</span>
                            </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                            <label>
                                <input name="state" type="radio" {{$data['state'] == 1 ? 'checked':''}} class="ace" value="1" />
                                <span class="lbl"> 禁用</span>
                            </label>
                             @else
                                <label>
                                    <input name="state" type="radio" checked class="ace" value="0" />
                                    <span class="lbl">正常</span>
                                </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                <label>
                                    <input name="state" type="radio" class="ace" value="1" />
                                    <span class="lbl"> 禁用</span>
                                </label>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" >是否显示</label>
                    <div class="col-sm-9">
                        <div class="radio">
                            @if(isset($data['status']))
                            <label>
                                <input name="status" type="radio" {{$data['status'] == 1 ? 'checked':''}} class="ace" value="1" />
                                <span class="lbl">显示</span>
                            </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                            <label>
                                <input name="status" type="radio" {{$data['status'] == 0 ? 'checked':''}} class="ace" value="0" />
                                <span class="lbl"> 隐藏</span>
                            </label>
                                @else
                                <label>
                                    <input name="status" type="radio" checked  class="ace" value="1" />
                                    <span class="lbl">显示</span>
                                </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                <label>
                                    <input name="status" type="radio"  class="ace" value="0" />
                                    <span class="lbl"> 隐藏</span>
                                </label>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="clearfix form-actions">
                    <div class="col-md-offset-5 col-md-7">
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
        var uploader="{{url('admin/pro/uploadify/2')}}";
    </script>
    <script src="{{asset('admin/myjs/promanage/singleImg.js')}}" type="text/javascript"></script>
    {{--表单验证插件--}}
    <script src="{{ asset('common/jqueryval/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('common/jqueryval/dist/localization/messages_zh.js') }}"></script>
    <script>
        $("#addForm").validate({
            rules: {
                name: {
                    maxlength:15,
                    required: true,
                }
            },
            messages:{
                name: {
                    required: "产品分类名称不能为空，请输入！",
                }
            }
        });
    </script>
@endsection
