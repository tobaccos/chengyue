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
            <form class="form-horizontal" role="form" id="addForm"  >
                {{csrf_field()}}
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" >分组名称</label>
                    <div class="col-sm-6">
                        <input type="text" class="col-xs-10 col-sm-5"   value="{{$comData['name']}}"/>
                    </div>
                    <div class="col-sm-3">
                        <a href="{{url('admin/pro_com/'.$comData['id'].'/edit')}}">
                            修改
                        </a>
                    </div>
                </div>
				@foreach($attrArr as $v)
				<div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" >{{$v['name']}}</label>
                    <div class="col-sm-6">
                        <div class="radio">
                            @if(isset($v['status']))
                                <label>
                                    <input name="status" type="radio" value="0" class="ace" {{$v['status']  == 0 ? 'checked':''}} />
                                    <span class="lbl">基本类型</span>
                                </label>

                                <label>
                                    <input name="status" type="radio" value="1" class="ace" {{$v['status'] == 1 ? 'checked':''}}/>
                                    <span class="lbl"> 多选</span>
                                </label>

                                <label>
                                    <input name="status" type="radio" value="2" class="ace" {{$v['status'] == 2 ? 'checked':''}}/>
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
					<div class="col-sm-3">
                        <a href="{{url('admin/pro_attr/'.$v['id'].'/edit')}}">修改</a>
                    </div>
                </div>
				@endforeach
            </form>
        </div>
    </div>
@endsection
