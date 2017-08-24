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
        .ml_0{
            margin-left:0px;
        }
    </style>
@endsection
@section('first_title','产品管理')
@section('second_title','产品属性')
@section('content')

    <div class="row">
        <div class="col-xs-12">
            <form class="form-horizontal" role="form" id="addForm" action="{{isset($data->id)?url('admin/pro_attr/'.$data->id):url('admin/pro_attr')}}" method="post">
                @if(isset($data->id))
                    <input type="hidden" name="_method" value="put">
                @endif
                {{csrf_field()}}
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" > 属性名称 </label>
                    <div class="col-sm-9">
                        <input type="text" id="proattr" name="name"  required  placeholder="请输入属性名称" class="col-xs-10 col-sm-5" value="{{isset($data->name)?$data->name:''}}" />
                    </div>
                </div>
				@if(!isset($data->id))
				<div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" > 属性分组 </label>
                    <div class="col-sm-9">
                        <select name="com_id" class="ml_0">
							{{--<option value="0">请选择...</option>--}}
							@foreach($comData as $v)
                                @if(isset($comId))
                                    <option value="{{$v['id']}}" {!! $comId == $v['id'] ? 'selected' :'' !!}>{{$v['name']}}</option>
                                @else
                                    <option value="{{$v['id']}}">{{$v['name']}}</option>
                                @endif
							@endforeach
						</select>
                    </div>
                </div>
				@endif
				
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" >类型</label>
                    <div class="col-sm-9">
                        <div class="radio">
                            @if(isset($data->status))
                            <label>
                                <input name="status" type="radio" value="0" class="ace" {{$data->status == 0 ? 'checked':''}} />
                                <span class="lbl">基本类型</span>
                            </label>

                            <label>
                                <input name="status" type="radio" value="1" class="ace" {{$data->status == 1 ? 'checked':''}}/>
                                <span class="lbl"> 多选</span>
                            </label>

                            <label>
                                <input name="status" type="radio" value="2" class="ace" {{$data->status == 2 ? 'checked':''}}/>
                                <span class="lbl"> 自定义</span>
                            </label>
                                @else
                                <label>
                                    <input name="status" type="radio" value="0" class="ace"  checked/>
                                    <span class="lbl">基本类型</span>
                                </label>

                                <label>
                                    <input name="status" type="radio" value="1" class="ace" />
                                    <span class="lbl"> 多选</span>
                                </label>

                                <label>
                                    <input name="status" type="radio" value="2" class="ace" />
                                    <span class="lbl"> 自定义</span>
                                </label>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" >状态</label>
                    <div class="col-sm-9">
                        <div class="radio">
                            @if(isset($data->state))
                                <label>
                                    <input name="state" type="radio" class="ace" value="0" {{$data->state == 0 ? 'checked':''}} />
                                    <span class="lbl">正常</span>
                                </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                <label>
                                    <input name="state" type="radio" class="ace" value="1" {{$data->state == 1 ? 'checked':''}}/>
                                    <span class="lbl"> 禁用</span>
                                </label>
                                @else
                            <label>
                                <input name="state" type="radio" class="ace" value="0" checked />
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
    {{--表单验证插件--}}
    <script src="{{ asset('common/jqueryval/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('common/jqueryval/dist/localization/messages_zh.js') }}"></script>
    <script>
        $("#addForm").validate({
            rules: {
                name: {
                    maxlength:15,
                    required: true,
                },
            },
            messages:{
                name: {
                    required: "产品属性名称不能为空，请输入！",
                }
            }
        });
    </script>
    @endsection

