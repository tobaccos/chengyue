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
                    <label class="col-sm-3 control-label no-padding-right" >广告位名称</label>
                    <div class="col-sm-9">
                        <input type="text" id="title" name="title" placeholder="广告位中文名称" value="{{isset($data['title'])?$data['title']:''}}"  class="col-xs-10 col-sm-5" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" >广告位别名</label>
                    <div class="col-sm-9">
                        <input type="text" id="alias" name="alias" placeholder="广告位英文别名" value="{{isset($data['alias'])?$data['alias']:''}}"  class="col-xs-10 col-sm-5" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" >广告位描述</label>
                    <div class="col-sm-9">
                        <input type="text" id="desc" name="desc" placeholder="广告位描述信息" value="{{isset($data['desc'])?$data['desc']:''}}" class="col-xs-10 col-sm-5" />
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
    {{--表单验证插件--}}
    <script src="{{ asset('common/jqueryval/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('common/jqueryval/dist/localization/messages_zh.js') }}"></script>
    <script>
        $("#addForm").validate({
            rules: {
                title: {
                    maxlength:15,
                    required: true
                },
                alias: {
                    maxlength:15,
                    required: true
                },
                desc: {
                    maxlength:25,
                    required: true,
                }
            },
            messages:{
                title: {
                    required: "广告名称不能为空，请输入！"
                },
                alias:{
                    required: "广告别名不能为空，请输入！"
                },
                desc:{
                    required: "广告描述不能为空，请输入！"
                }
            }
        });
    </script>
@endsection