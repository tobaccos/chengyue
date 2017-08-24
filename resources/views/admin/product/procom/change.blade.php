@extends('admin.common.base')
@section('css')
    <link rel="stylesheet" href="{{ asset('admin/mycss/common/alertwords.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/mycss/select/bootstrap-select.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/mycss/procom/change.css') }}" />
@endsection
@section('first_title','产品管理')
@section('second_title','产品属性')
@section('content')

    <div class="row">
        <div class="col-xs-12">
            <form class="form-horizontal" role="form" id="addForm" action="{{isset($data['id'])?url('admin/pro_com/'.$data['id']):url('admin/pro_com')}}" method="post" enctype="multipart/form-data">
                @if(isset($data['id']))
                    <input type="hidden" name="_method" value="put">
                @endif
                {{csrf_field()}}
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" >分组名称</label>
                    <div class="col-sm-9">
                        <input type="text" id="myname" name="name"  required  class="col-xs-10 col-sm-5"  placeholder="请输入分组名称" value="{{isset($data['name'])?$data['name']:''}}"/>
                    </div>
                </div>
                {{--原有属性--}}
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" >以有属性</label>
                    <div class="col-sm-4">
                        <select id="attrOld" name="attrOld[]" class="selectpicker show-tick form-control ml_0" multiple data-live-search="false">
                            @foreach($attrArr as $v)
                                @if(isset($v['select']) && $v['select'])
                                <option value="{{$v['id']}}" selected="selected">{{$v['name']}}</option>
                                @else
                                <option value="{{$v['id']}}">{{$v['name']}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" >状态</label>
                    <div class="col-sm-9">
                        <div class="radio">
                            @if(isset($data->state))
                                <label>
                                    <input name="state" type="radio" class="ace" value="0" {{$data['state'] == 0 ? 'checked':''}} />
                                    <span class="lbl">正常</span>
                                </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                <label>
                                    <input name="state" type="radio" class="ace" value="1" {{$data['state'] == 1 ? 'checked':''}}/>
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
                    <div class="clearfix form-actions">
                        <div class="col-md-offset-5 col-md-9">
                            <button class="btn btn-info" type="submit">
                                <i class="ace-icon fa fa-check bigger-110"></i>
                                提交
                            </button>
                        </div>

                    </div>
                </div>
            </form>

            {{--属性弹出框--}}
            <div class="modal fade" id="attrModal" tabindex="-1" role="dialog"
                 aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close"
                                    data-dismiss="modal" aria-hidden="true">
                                &times;
                            </button>
                            <h4 class="modal-title" id="myModalLabel">
                                添加产品属性
                            </h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group row">
                                <label class="col-sm-3 control-label no-padding-right" > 属性名称 </label>
                                <div class="col-sm-9">
                                    <input type="text" id="proattr" name="name" attrVal=""  required  placeholder="请输入属性名称" class="col-xs-10 col-sm-5" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 control-label no-padding-right" >类型</label>
                                <div class="col-sm-9">
                                    <div class="radio">
                                        <label>
                                            <input name="status" type="radio"  value="0" class="ace attrRadio" />
                                            <span class="lbl">基本类型</span>
                                        </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                        <label>
                                            <input name="status" type="radio" value="1" class="ace attrRadio" />
                                            <span class="lbl"> 多选</span>
                                        </label>

                                        <label>
                                            <input name="status" type="radio" value="2" class="ace attrRadio" />
                                            <span class="lbl"> 自定义</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default"
                                    data-dismiss="modal">关闭
                            </button>
                            <button type="button" class="btn btn-primary submitAttr">
                                提交更改
                            </button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal -->
            </div>
        </div>
        @endsection
        @section('js')
            <script src="{{ asset('admin/mycss/select/bootstrap-select.min.js') }}"></script>
            <script src="{{ asset('admin/mycss/select/i18n/defaults-*.min.js') }}"></script>
            <script src="{{ asset('admin/myjs/procom/change.js') }}"></script>
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
                            required: "产品属性分组名称不能为空，请输入！",
                        }
                    }
                });
            </script>

@endsection




















