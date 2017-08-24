@extends('admin.common.base')
@section('css')
    <link rel="stylesheet" href="{{ asset('admin/mycss/common/alertwords.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/mycss/promanage/list.css') }}" />
@endsection
@section('first_title','产品管理')
@section('second_title','产品分类')
@section('content')

    <a href="{{ url('admin/category/create') }}">
        <button class="btn  btn-xs btn-info  myadd">
            <i class="ace-icon fa fa-check"></i>
            添加分类
            <i class="ace-icon fa fa-arrow-right icon-on-right"></i>
        </button>
    </a>
    <div class="row">
        <div class="col-xs-12">
                        <table id="dynamic-table" class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>产品分类</th>
                                <th>排序</th>
                                <th>
                                    <i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i>
                                    更新日期
                                </th>
                                <th class="hidden-480">记录人</th>
                                <th>状态</th>
                                <th class="hidden-480">是否在前台显示</th>
                                <th class="hidden-480">图片</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $v)
                            <tr>
                                <td>
                                    <a href="{{url('admin/category/'.$v["id"].'/edit')}}">{{$v['name']}}</a>
                                </td>
                                <td class="hidden-480 sort" >{{$v['sort']}}</td>
                                <input type="hidden" class="sortid" value="{{ $v["id"] }}">
                                <td>{{$v['updated_at']}}</td>
                                <td class="hidden-480">{{getAdminById($v['clert'])}}</td>
                                <td>
                                    @if($v['state'])
                                        <span class="label label-grey arrowed-right"> 禁用</span>
                                    @else
                                        <span class="label label-success arrowed-in arrowed-in-right"> 正常</span>
                                    @endif
                                </td>
                                <td class="hidden-480">{{$v['status'] ? '显示': '隐藏'}}
                                </td>
                                <td class="hidden-480">
                                    @if(isset($v['pic']) && !empty($v['pic']))
                                    <img src="{{PRO_CATE_IMG_PATH . $v['pic']}}" width="50">
                                    @else
                                        <img src="{{ url('admin/images/no.png') }}"  width="50">
                                        <input type="hidden" name="pic" value="">
                                    @endif
                                </td>

                                <td>
                                    <div class="hidden-sm hidden-xs action-buttons">
                                        <a class="green" href="{{url('admin/category/'.$v['id'].'/edit')}}">
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
                                                    <a href="{{url('admin/category/'.$v['id'].'/edit')}}" class="tooltip-success" data-rel="tooltip" title="Edit">
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
        //删除分类
        function delCate(cate_id) {
            layer.confirm('您确定要删除这个分类吗？', {
                btn: ['确定','取消'] //按钮
            }, function(){
                $.post("{{url('admin/category/')}}/" + cate_id, {'_method':'delete','_token':"{{csrf_token()}}"}, function (data) {
                    if(data.status==1){
                        location.href = location.href;
                        layer.msg(data.msg, {icon: 6});
                    }else{
                        layer.msg(data.msg, {icon: 5});
                    }
                });
            });
        }

        // 排序
        var url = "{{ url('admin/category/sort') }}";
        $('.sort').dblclick(function () {
            var that = $(this)

            var inputs =  $('td input');
            if(inputs.length>0){
                inputs.each(function (index ,item) {
                    var val = $(this).val();
                    $(this).parent().html(val);
                })
            }
           sort = $(this).text();
           console.log(sort);
           input="<input id='sortNum' 'type='number' value='"+sort+"'/>";
           $(this).html(input);

            sortid = $(this).next().val();
            console.log(sortid)
//            alert(sortNum);

            that.find('input').blur(function () {
                var sortNum =$(this).val();
                sortNum = sortNum ?sortNum:sort;
                var data ={sort:sortNum,id:sortid};
                console.log(data);


                console.log(11111);
                $(this).parent().html(sortNum);
                $.ajax({
                   type: "POST",
                    url:url,
                    data:data,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success:function (data) {
                       console.log(data);
//                        if(data == 200){
//
//                        }
                    },
                    error:function (data) {

                    }

//
                });
            });

        });
    </script>
    @endsection


