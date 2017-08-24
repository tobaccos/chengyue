@extends('admin.common.base')
@section('css')
    <link rel="stylesheet" href="{{ asset('admin/mycss/common/alertwords.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/mycss/ad/list.css') }}" />
@endsection
@section('first_title','广告管理')
@section('second_title','广告列表')
@section('content')

    <a href="{{ url('admin/ad/pos_add') }}">
        <button class="btn  btn-xs btn-info  myadd">
            <i class="ace-icon fa fa-check"></i>
            添加广告位
            <i class="ace-icon fa fa-arrow-right icon-on-right"></i>
        </button>
    </a>
    <a href="{{ url('admin/ad/index') }}">
        <button class="btn  btn-xs btn-info  myadd">
            <i class="ace-icon fa fa-check"></i>
            查看广告
            <i class="ace-icon fa fa-arrow-right icon-on-right"></i>
        </button>
    </a>
    <div class="row">
        <div class="col-xs-12">
                        <table id="dynamic-table" class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>标题</th>
                                <th>别名</th>
                                <th>描述</th>
                                <th>
                                    <i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i>
                                    更新日期
                                </th>
                                <th>状态</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $v)
                            <tr>
                                <td>
                                    <a href="{{url('admin/ad/pos_edit/'.$v["id"])}}">{{$v['title']}}</a>
                                </td>
                                <td>{{$v['alias']}}</td>
                                <td>{{$v['desc']}}</td>
								<td>{{$v['updated_at']}}</td>
                                <td>
                                    @if($v['state'])
                                        <span class="label label-success arrowed-in arrowed-in-right"> 正常</span>
                                    @else
                                        <span class="label label-grey arrowed-right"> 禁用</span>
                                    @endif
                                </td>

                                <td>
                                    <div class="hidden-sm hidden-xs action-buttons">
                                        <a class="green" href="{{url('admin/ad/pos_edit/'.$v['id'])}}">
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
                                                    <a href="{{url('admin/ad/edit/'.$v['id'])}}" class="tooltip-success" data-rel="tooltip" title="Edit">
                                                            <span class="green">
                                                                <i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
                                                            </span>1
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;" onclick="delCate({{$v['id']}})" class="tooltip-error" data-rel="tooltip" title="Delete">
                                                            <span class="red1">
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
        //删除
        function delCate(cate_id) {
            layer.confirm('您确定要删除这个广告位吗？', {
                btn: ['确定','取消'] //按钮
            }, function(){
                $.post("{{url('admin/ad/pos_del/')}}/" + cate_id, {'_token':"{{csrf_token()}}"}, function (data) {
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
    @endsection


