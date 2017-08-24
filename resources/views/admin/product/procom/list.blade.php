@extends('admin.common.base')
@section('css')
    <link rel="stylesheet" href="{{ asset('admin/mycss/common/alertwords.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/mycss/promanage/list.css') }}" />
@endsection
@section('first_title','产品管理')
@section('second_title','产品属性')
@section('notice')
<div class="alertwords">
产品分类只有一级分类
</div>
@endsection

@section('content')

    <button class="btn  btn-xs btn-danger myadd" id="mydel" >
        <i class="ace-icon fa fa-bolt bigger-110"></i>
        批量删除
        <i class="ace-icon fa fa-trash-o icon-only icon-on-right"></i>
    </button>
    <a href="{{ url('admin/pro_com/create') }}">
        <button class="btn  btn-xs btn-success  myadd">
            <i class="ace-icon fa fa-check"></i>
            添加分组
            <i class="ace-icon fa fa-arrow-right icon-on-right"></i>
        </button>
    </a>
	<a href="{{ url('admin/pro_attr/create') }}">
        <button class="btn  btn-xs btn-info  myadd">
            <i class="ace-icon fa fa-check"></i>
            添加属性
            <i class="ace-icon fa fa-arrow-right icon-on-right"></i>
        </button>
    </a>
  <a href="{{ url('admin/pro_attr') }}">
          <button class="btn  btn-xs btn-info  myadd">
              <i class="ace-icon fa fa-check"></i>
              查看属性
              <i class="ace-icon fa fa-arrow-right icon-on-right"></i>
          </button>
      </a>
    <div class="row">
        <div class="col-xs-12">
                        <table id="dynamic-table" class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>
                                    <input type="checkbox" value=""   onclick="swapCheck()">&nbsp;全选</input>
                                </th>
                                <th>属性组名称</th>
                                <th>
                                    <i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i>
                                    更新日期
                                </th>
                                <th class="hidden-480">记录人</th>
                                <th>状态</th>
                                <th class="hidden-480">组合内容</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $v)
                            <tr>
                                <td>
                                    <input type="checkbox" value='{{$v["id"]}}' del="delcheck" ></input>
                                </td>
                                <td>
                                    <a href="{{url('admin/pro_com/'.$v['id'].'/edit')}}">{{$v['name']}}</a>
                                </td>
                                <td>{{$v['updated_at']}}</td>
                                <td class="hidden-480">{{getAdminById($v['clert'])}}</td>
                                <td>{{$v['state']? '禁用': '正常'}}</td>
                                <td class="hidden-480">
									<?php  $comArr = explode('_', $v['conbination']);?>
									@foreach($comArr as $vv)
                                            <span class="label label-warning arrowed arrowed-right">{{getComNameById($vv)}}</span>
									@endforeach
                                </td>

                                <td>
                                    <div class="hidden-sm hidden-xs action-buttons">
                                        {{--<a class="blue" href="#">--}}
                                            {{--<i class="ace-icon fa fa-search-plus bigger-130 myicon"></i>--}}
                                        {{--</a>--}}

                                        <a class="green" href="{{url('admin/pro_com/'.$v['id'].'/edit')}}">
                                            <i class="ace-icon fa fa-pencil bigger-130 myicon"></i>
                                        </a>

                                        <a class="red" href="javascript:;" onclick="delCate({{$v['id']}})">
                                            <i class="ace-icon fa fa-trash-o bigger-130 myicon"></i>
                                        </a>
                                    </div>
                                    {{--缩小的下拉按钮--}}
                                    <div class="hidden-md hidden-lg">
                                        <div class="inline pos-rel">
                                            <button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown" data-position="auto">
                                                <i class="ace-icon fa fa-caret-down icon-only bigger-120"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
                                                <li>
                                                    <a href="{{url('admin/pro_com/'.$v['id'].'/edit')}}" class="tooltip-success" data-rel="tooltip" title="Edit">
                                                            <span class="green">
                                                                <i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
                                                            </span>1
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;" onclick="delCate({{$v['id']}})" class="tooltip-error" data-rel="tooltip" title="Delete">
                                                            <span class="red">
                                                                <i class="ace-icon fa fa-trash-o bigger-120"></i>
                                                            </span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
            <div  class="page">
                {{$data->links()}}
            </div>
                </div>
            </div>
    </div><!-- /.modal-dialog -->
</div>
@endsection
@section('js')
    <script>
        //删除分类
        function delCate(cate_id) {
            layer.confirm('您确定要删除这个属性组吗？', {
                btn: ['确定','取消'] //按钮
            }, function(){
                $.post("{{url('admin/pro_com/')}}/" + cate_id, {'_method':'delete','_token':"{{csrf_token()}}"}, function (data) {
                    if(data.status==1){
                        location.href = location.href;
                        layer.msg(data.msg, {icon: 6});
                    }else{
                        layer.msg(data.msg, {icon: 5});
                    }
                });
            });
        }
    </script>
    <script>
        //批量删除地址
        var delUrl="{{url('admin/pro_com/dels')}}";
    </script>
    <script src="{{ asset('admin/myjs/promanage/del.js') }}"></script>
    @endsection
