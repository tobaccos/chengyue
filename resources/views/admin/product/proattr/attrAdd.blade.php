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
    </style>
@endsection
@section('first_title','产品管理')
@section('second_title','产品属性')
@section('content')

    <div class="row">
        <div class="col-xs-12">
            <form class="form-horizontal" role="form" id="addForm" action="{{url('admin/pro_attr')}}" method="post">
                {{csrf_field()}}

                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" > 属性名称 </label>
                    <div class="col-sm-9">
                        <input type="text" id="proattr" name="name"  required  placeholder="请输入属性名称" class="col-xs-10 col-sm-5" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" >类型</label>
                    <div class="col-sm-9">
                        <div class="radio">
                            <label>
                                <input name="status" type="radio"  value="0" class="ace" />
                                <span class="lbl">基本类型</span>
                            </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                            <label>
                                <input name="status" type="radio" value="1" class="ace" />
                                <span class="lbl"> 多选</span>
                            </label>

                            <label>
                                <input name="status" type="radio" value="2" class="ace" />
                                <span class="lbl"> 自定义</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" >状态</label>
                    <div class="col-sm-9">
                        <div class="radio">
                            <label>
                                <input name="state" type="radio" class="ace" value="0" />
                                <span class="lbl">正常</span>
                            </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                            <label>
                                <input name="state" type="radio" class="ace" value="1" />
                                <span class="lbl"> 禁用</span>
                            </label>
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
