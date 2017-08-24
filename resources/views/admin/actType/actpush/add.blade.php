@extends('admin.common.base')
@section('css')
    <link rel="stylesheet" href="{{ asset('admin/mycss/common/alertwords.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/mycss/promanage/proAdd.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/mycss/activity/add.css') }}" />
    <style>
        #activity .submenu{
            display:block;
        }
        #activity>a{
            color:#5999D0;
        }
    </style>
@endsection
@section('first_title','促销管理')
@section('second_title','今日推荐')
@section('content')
    <div class="row">
        <div class="col-xs-12">

            <form class="form-horizontal" role="form" id="addForm"  method="post">
                {{csrf_field()}}
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" > 产品名称： </label>
                    <div class="col-sm-9">
                        <input type="text" id="proname" name="name"  placeholder="产品名称" class="col-xs-10 col-sm-5" maxlength="20"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" > 上架时间：</label>
                    <div class="input-daterange input-group col-sm-9">
                        <input type="text" class="input-sm form-control sjdate" placeholder="上架时间" name="show_time" />
                        <span class="input-group-addon">
                          <i class="fa fa-calendar" aria-hidden="true"></i>
                       </span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" > 分类：</label>
                    <div class="col-sm-9">
                        <select name="type_id">
                            @foreach($catData as $v)
                                <option value="{{$v['id']}}">{{$v['name']}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group ">
                    <label class="col-sm-2 control-label no-padding-right" > 数量： </label>
                    <div class="col-sm-9">
                        <input type="number" id="proname" name="number"  placeholder="请输入数量" class="col-xs-10 col-sm-5 num" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" > 缩略图： </label>
                    <div class="col-sm-9">
                        <input id="file_upload1" name="file_thumbing" type="file" multiple="true">
                        	<p style="margin-top: 8px;color: #FF0000;">温馨提示:缩略图比例为1:1</p>
                        <img id="art_thumb_img" style="width:100px;height:100px;">
                        <input type="hidden" size="50" name="thumbing" value="" class="pictext">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" > 产品图片： </label>
                    <div class="col-sm-9">
                        <input name="pic" type="hidden" >
                        <input id="file_upload" name="file_upload" type="file" multiple="true">
                        <div class="fileWarp">
                            <fieldset>
                                <ul>

                                </ul>
                                <div id="fileQueue">
                                </div>
                            </fieldset>
                        </div>
                        <p style="color: #FF0000;">温馨提示:缩略图比例为3:2&nbsp;&nbsp;&nbsp;&nbsp;最多上传5张图片</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" > 产品利率： </label>
                    <div class="col-sm-9">
                        <input type="number" id="proname" name="rate"  placeholder="当前产品的默认利率" class="col-xs-10 col-sm-5"  value="0.001"  min="0.001" step="0.001" onchange="var val=parseFloat(this.value).toFixed(3);if(val>=1 |val<=0){val=0.001};this.value=val"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" > 产品详情： </label>
                    <div class="col-sm-9">
                        <script type="text/javascript" charset="utf-8" src="{{asset('admin/components/ueditor/ueditor.config.js')}}"></script>
                        <script type="text/javascript" charset="utf-8" src="{{asset('admin/components/ueditor/ueditor.all.js')}}"> </script>
                        <script type="text/javascript" charset="utf-8" src="{{asset('admin/components/ueditor/lang/zh-cn/zh-cn.js')}}"></script>
                        <script id="editor" name="content" type="text/plain" style="width:860px;height:300px;"></script>
                        <script type="text/javascript">
                            var ue = UE.getEditor('editor');
                        </script>
                        <style>
                            .edui-default{line-height: 28px;}
                            div.edui-combox-body,div.edui-button-body,div.edui-splitbutton-body
                            {overflow: hidden; height:20px;}
                            div.edui-box{overflow: hidden; height:22px;}
                        </style>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" >状态：</label>
                    <div class="col-sm-9">
                        <div class="radio">
                            <label>
                                <input name="state" type="radio" value="0" class="ace" checked />
                                <span class="lbl">正常</span>
                            </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <label>
                                <input name="state" type="radio" value="1" class="ace" />
                                <span class="lbl">禁用</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" > 选择属性：</label>
                    <div class="col-sm-9">
                        <select class="mysel form-control shift-info" id="mysel"  name="com_id">
                            @foreach($comData as $v)
                                <option value="{{$v['id']}}">{{$v['name']}}</option>
                            @endforeach
                        </select>
                        <button type="button" class="btn btn-xs btn-info bigadd"  onclick="addBig()">添加组合属性</button>
                    </div>
                </div>
                <div class="form-group attralert">
                    <li class="text-warning bigger-110 red col-sm-9">
                        更改产品属性组合，将会重置属性信息，请慎重！！
                        <i class="ace-icon fa fa-exclamation-triangle col-sm-2" ></i>

                    </li>
                </div>
                <div class="attrhidden"></div>
                <div class="attrlists"></div>
                <div class="clear"></div>
                <div class="clearfix form-actions">
                    <div class="col-md-offset-5 col-md-7">
                        <button class="btn btn-info" type="button" id="submitBtn">
                            <i class="ace-icon fa fa-check bigger-110"></i>
                            确认提交
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
    <script src="{{ asset('admin/editable/js/jquery.editable-select.min.js') }}"></script>
    <script src="{{asset('admin/myjs/promanage/proAdd.js')}}" type="text/javascript"></script>
    <script>
        var flage=true;
        var selUrl="{{url('admin/pro/getAjaxCom')}}";
        var formUrl="{{url('product/attrAdd')}}";
        var url ="{{url('admin/product/ajaxAttrAdd')}}";
        var time= '{{time()}}';
        var token="{{csrf_token()}}";
        var swf="{{asset('admin/components/uploadify/uploadify.swf')}}";
        var uploader="{{url('admin/pro/uploadify/1')}}";
        var fd="{{url('admin/recommend')}}";
    </script>
    <script src="{{asset('admin/myjs/promanage/uploadeImg.js')}}" type="text/javascript"></script>
    {{--表单验证插件--}}
    {{--<script src="{{ asset('common/jqueryval/jquery.validate.min.js') }}"></script>--}}
    {{--<script src="{{ asset('common/jqueryval/dist/localization/messages_zh.js') }}"></script>--}}
    {{--<script src="{{ asset('admin/myjs/promanage/jqueryVal.js') }}"></script>--}}
    {{--编辑器--}}
    {{--时间插件--}}
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
    {{--时间日期--}}
    <script src="{{asset('admin/myjs/promanage/datetime.js')}}" type="text/javascript"></script>
@endsection
