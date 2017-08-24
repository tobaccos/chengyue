@extends('admin.common.base')
@section('css')
    <link rel="stylesheet" href="{{ asset('admin/mycss/common/alertwords.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/mycss/activity/list.css') }}" />
@endsection
@section('first_title','促销管理')
@section('second_title','活动专区')
@section('content')

    <button class="btn  btn-xs btn-danger myadd" id="mydel" >
        <i class="ace-icon fa fa-bolt bigger-110"></i>
        批量删除
        <i class="ace-icon fa fa-trash-o icon-only icon-on-right"></i>
        </button>
    <a href="{{ url('admin/activity/create') }}">
        <button class="btn  btn-xs btn-info  myadd">
            <i class="ace-icon fa fa-check"></i>
            添加产品
            <i class="ace-icon fa fa-arrow-right icon-on-right"></i>
        </button>
    </a>
    <form class="form-search" action="" method="get">
        <select name="type_id" class="proclass">
            <option value="0">按分类搜索</option>
            @foreach($cateData as $cate)
                <?php
                    if(isset($_GET['type_id']) && $_GET['type_id'] == $cate['id'])
                        $select = 'selected';
                    else
                        $select = '';
                ?>
            <option value="{{$cate['id']}}" {{$select}}>{{$cate['name']}}</option>
            @endforeach
        </select>
            <div class="col-xs-8 col-sm-11  hidden-480" >
                <div class="input-daterange input-group dateform">
                    <input type="text" class="input-sm form-control" placeholder="添加产品时间搜索" name="start" value="{{isset($_GET['start'])?$_GET['start']:''}}" />
                <span class="input-group-addon">
                    <i class="fa fa-exchange"></i>
                </span>
                    <input type="text" class="input-sm form-control" placeholder="添加产品时间搜索" name="end" value="{{isset($_GET['end'])?$_GET['end']:''}}"/>
                </div>
            </div>
    <div class="nav-search" id="nav-search">

            <span class="input-icon">
                <input type="text" placeholder="按产品名称搜索" class="nav-search-input" id="nav-search-input" name="keyword" autocomplete="off" value="{{isset($_GET['keyword'])?$_GET['keyword']:''}}" maxlength="10"/>
                <i class="ace-icon fa fa-search nav-search-icon"></i>
            </span>
        <input type="submit" class="btn btn-xs btn-info searchbtn" value="搜索">

    </div>
    </form>
    <div class="row">
        <div class="col-xs-12">
            <table id="dynamic-table" class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th>
                        <input type="checkbox" value=""   onclick="swapCheck()">&nbsp;全选</input>
                    </th>
                    <th id="proname" class="tr_right">
                        产品名称
                        <a href="javascript:;" onclick="dataOrder(this,'id')" >
                            <i  aria-hidden="true" class="order_right">
                                <img src="{{url('admin/components/tablesorter/themes/blue/asc.gif')}}">
                            </i>
                        </a>
                    </th>
                    <th>
                        产品分类
                    </th>
                    <th  class="hidden-480 tr_right"  id="dateorder">
                        更新日期
                        <a href="javascript:;" onclick="dataOrder(this,'updated_at')" >
                            <i  aria-hidden="true" class="order_right">
                                <img src="{{url('admin/components/tablesorter/themes/blue/asc.gif')}}">
                            </i>
                        </a>
                    </th>
                    <th class="hidden-480 tr_right"  id="volume">
                        销量
                        <a href="javascript:;" onclick="dataOrder(this,'volume')" >
                            <i  aria-hidden="true" class="order_right">
                                <img src="{{url('admin/components/tablesorter/themes/blue/asc.gif')}}">
                            </i>
                        </a>
                    </th>
                    <th class="hidden-480 tr_right" id="collection">
                        收藏
                        <a href="javascript:;" onclick="dataOrder(this,'collection')" >
                            <i  aria-hidden="true" class="order_right">
                                <img src="{{url('admin/components/tablesorter/themes/blue/asc.gif')}}">
                            </i>
                        </a>
                    </th>
                    <th>状态</th>
                    {{--<th class="hidden-480">是否在前台显示</th>--}}
                    <th class="hidden-480">图片</th>
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
                            <a href="{{url('admin/activity/'.$v["id"].'/edit')}}">{{$v['name']}}</a>
                        </td>
                        <td>{{getCateNameById($v['type_id'])}}</td>
                        <td  class="hidden-480">{{$v['updated_at']}}</td>
                        <td class="hidden-480">{{$v['volume']}}</td>
                        <td  class="hidden-480">{{$v['collection']}}</td>
                        <td id="greenState">
{{--                            {{$v['state']? '禁用': '正常'}}--}}
                            @if($v['state'])
                                <span class="label label-grey arrowed-right"> 禁用</span>
                            @else
                                <span class="label label-success arrowed-in arrowed-in-right"> 正常</span>
                            @endif
                        </td>
                        {{--<td class="hidden-480">{{$v['status'] ? '显示': '隐藏'}}--}}
                        </td>
                        <td class="hidden-480">
                            <img src="{{PRO_IMG_PATH . $v['thumbing']}}" width="50">
                        </td>

                        <td>
                            <div class="hidden-sm hidden-xs action-buttons">
                                <a class="green" href="{{url('admin/activity/'.$v['id'].'/edit')}}">
                                    <i class="ace-icon fa fa-pencil bigger-130 myicon"></i>
                                </a>

                                <a class="red" href="javascript:;" onclick="delCate({{$v['id']}})">
                                    <i class="ace-icon fa fa-trash-o bigger-130 myicon  ml_17"></i>
                                </a>
                                <a class="blue" href="javascript:;" onclick="copyCate({{$v['id']}})">
                                    <i class="ace-icon fa fa-files-o bigger-130 myicon ml_17" aria-hidden="true"></i>
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
                                            <a href="{{url('admin/activity/'.$v['id'].'/edit')}}" class="tooltip-success" data-rel="tooltip" title="Edit">
                                                            <span class="green">
                                                                <i class="ace-icon fa fa-pencil-square-o bigger-120" id="hiddenNO"id="hiddenNO"></i>
                                                            </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:;" onclick="delCate({{$v['id']}})" class="tooltip-error" data-rel="tooltip" title="Delete">
                                                            <span class="red">
                                                                <i class="ace-icon fa fa-trash-o bigger-120 "  id="hiddenNO"></i>
                                                            </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:;" onclick="copyCate({{$v['id']}})" class="tooltip-error" data-rel="tooltip" title="Cooy">
                                                            <span class="blue">
                                                                <i class="ace-icon fa fa-files-o bigger-120"></i>
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
    {{--时间插件js--}}
    <script src="{{ asset('admin/components/fuelux/js/spinbox.js') }}"></script>
    <script src="{{ asset('admin/components/bootstrap-datepicker/dist/js/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('admin/components/bootstrap-timepicker/js/bootstrap-timepicker.js') }}"></script>
    <script>
        //批量删除地址
        var delUrl="{{url('admin/activity/dels')}}";
        var orderUrl="{{ url('admin/activity') }}";
        var ascUrl="{{url('admin/components/tablesorter/themes/blue/asc.gif')}}";
        var descUrl="{{url('admin/components/tablesorter/themes/blue/desc.gif')}}";
        //单个删除地址
        var singleDel="{{url('admin/activity/')}}/";
        //复制地址
        var copyPro="{{url('admin/activity/copy')}}/";
    </script>
    {{--产品列表--}}
    <script src="{{ asset('admin/myjs/promanage/list.js') }}"></script>
    {{--单个产品删除--}}
    <script src="{{ asset('admin/myjs/promanage/singleDel.js') }}"></script>
    {{--多个产品复制，删除--}}
    <script src="{{ asset('admin/myjs/promanage/del.js') }}"></script>
@endsection
