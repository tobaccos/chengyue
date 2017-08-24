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
@section('second_title','产品分类')
@section('content')

    <div class="row">
        <div class="col-xs-12">
            <form class="form-horizontal" role="form" id="addForm" action="{{url('admin/category')}}" method="post" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" >分类名称</label>
                    <div class="col-sm-9">
                        <input type="text" id="myname" name="name"   placeholder="请输入分类名称" required   class="col-xs-10 col-sm-5" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" >分类图片</label>
                    <div class="col-sm-9">
                        <input type="file" id="myemail" name="pic"  class="col-xs-10 col-sm-5" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" >状态</label>
                    <div class="col-sm-9">
                        <select name="state">
                                <option value="0" >正常</option>
                                <option value="1" >禁用</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" >是否显示</label>
                    <div class="col-sm-9">
                        <select name="status">
                                <option value="1" >开</option>
                                <option value="0" >关</option>
                        </select>
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