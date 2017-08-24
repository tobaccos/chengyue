@extends('admin.common.base')
@section('css')
<link rel="stylesheet" href="{{ asset('admin/mycss/common/alertwords.css') }}" />
<link rel="stylesheet" href="{{ asset('admin/mycss/user/userClass.css') }}" />
@endsection
@section('first_title','用户管理')
@section('second_title','分类列表')
@section('content')
  <a href="{{ url('admin/user/userclass/userClassAdd') }}">
    <button class="btn btn-xs btn-info myadd">
      <i class="ace-icon fa fa-bolt bigger-110"></i>
      添加用户分类
      <i class="ace-icon fa fa-arrow-right icon-on-right"></i>
    </button>
  </a>
<div class="row">
  <div class="col-xs-12">
    <!-- PAGE CONTENT BEGINS -->
    <div class="row">
      <div class="col-xs-12">
        <table id="simple-table" class="table  table-bordered table-hover">
          <thead>
            <tr>
              {{--<th class="center">--}}
                {{--<label class="pos-rel">--}}
                  {{--<input type="checkbox" class="ace" onclick="swapCheck()"/>--}}
                  {{--<span class="lbl"></span>--}}
                {{--</label>--}}
              {{--</th>--}}
              {{--<th class="center">--}}
                {{--<input type="checkbox" value=""   onclick="swapCheck()">&nbsp;全选</input>--}}
              {{--</th>--}}
              <th class="detail-col">编号</th>
              <th>类型名称</th>
              <th class="hidden-480">记录人</th>
              <th>
                <i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i>
                开通费用（月）
              </th>
              <th>
                <i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i>
                开通费用（年）
              </th>
              <th >操作</th>
            </tr>
          </thead>
          <tbody>
            @foreach($data as $k => $v)
            <tr>
              {{--<td class="center">--}}
                {{--<label class="pos-rel">--}}
                  {{--<input type="checkbox"  />--}}
                  {{--<span class="lbl"></span>--}}
                {{--</label>--}}
              {{--</td>--}}
              <td>
                {{$v -> id}}
              </td>
              <td>
                {{$v -> name}}
              </td>
              <td class="hidden-480">{{$v -> uname}}</td>
              <td>{{$v -> month_money}}</td>
              <td>{{$v -> year_money}}</td>
              <td>
                <div class="hidden-sm hidden-xs ">
                  <a href="{{ url('admin/user/userclass/userClassChange') }}/{{$v -> id}}"><input type="button" id="man_del" class="btn btn-xs btn-info" value="修改"/> </a>
                  <a href="{{url('admin/user/userlass/userClassDel')}}/{{$v -> id}}}" >
										<input type="button"  class="btn btn-xs btn-danger del" value="删除"/>

                  </a>
                </div>
                <div class="hidden-md hidden-lg">
                  <div class="inline pos-rel">
                    <button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown" data-position="auto">
                      <i class="ace-icon fa fa-cog icon-only bigger-110"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
                      <!-- <li>
                        <a href="#" class="tooltip-info" data-rel="tooltip" title="View">
                          <span class="blue">
                            <i class="ace-icon fa fa-search-plus bigger-120"></i>
                          </span>
                        </a>
                      </li> -->
                      <li>
                        <a href="{{ url('admin/user/userclass/userClassChange') }}/{{$v -> id}}" class="tooltip-success" data-rel="tooltip" title="Edit">
                          <span class="green">
                            <i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
                          </span>
                        </a>
                      </li>
                      <li>
                        <a href="{{url('admin/user/userlass/userClassDel')}}/{{$v -> id}}}" class="tooltip-error" data-rel="tooltip" title="Delete">
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
      </div>
    </div>
		<div style="text-align:center">
		{{ $data -> appends($request) -> links() }}
		</div>
  </div>
</div>
@endsection
@section('js')
<script src="{{ asset('admin/myjs/user/userClass.js') }}"></script>

@endsection
