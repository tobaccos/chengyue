@extends('admin.common.base')
@section('css')
  <link rel="stylesheet" href="{{ asset('admin/mycss/common/alertwords.css') }}" />
  <link rel="stylesheet" href="{{ asset('admin/mycss/admin/admin.css') }}" />
@endsection
@section('first_title','权限管理')
@section('second_title','管理员列表')
@section('content')

  <a href="{{ url('admin/admin/adminAdd') }}">
    <button class="btn btn-xs btn-info  mybtn ">
      <i class="ace-icon fa fa-bolt bigger-110"></i>
      添加管理员
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
              <!-- <th class="center">
                <label class="pos-rel">
                <input type="checkbox" class="ace" onclick="swapCheck()"/>
                  <span class="lbl"></span>
                </label>
              </th> -->
              <th class="detail-col">编号</th>
              <th>名称</th>
              <th class="hidden-480">邮箱</th>
              <th class="hidden-480">分组</th>
              <th class="hidden-480">
                <i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i>
                创建时间
              </th>
              <th class="hidden-480">
                <i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i>
                更新时间
              </th>
              <th>状态</th>
              <th>操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data as $v)
              <tr>
                <!-- <td class="center">
                  <label class="pos-rel">
                    <input type="checkbox" class="ace" />
                    <span class="lbl"></span>
                  </label>
                </td> -->
                <td>
                  {{$v -> id}}
                </td>
                <td>
                  {{$v -> name}}
                </td>
                <td class="hidden-480"> {{$v -> email}}</td>
                <td class="hidden-480">{{$v -> gName}} </td>
                <td class="hidden-480"> {{$v -> created_at}}</td>
                <td class="hidden-480"> {{$v -> updated_at}}</td>


                <td >
                  @if($v -> state ==0)
                    <span class="label label-sm label-warning">启用</span>
                  @else
                    <span class="label label-sm label-success">禁用</span>
                @endif
                <td>
                  <div class="hidden-sm hidden-xs">
                    @if($v -> state == 0)
                      <a href="{{ url('admin/admin/state') }}/{{$v -> id}}" ><button class="btn btn-xs btn-success">禁用</button></a>
                    @else
                      <a href="{{ url('admin/admin/state') }}/{{$v -> id}}" ><button class="btn btn-xs btn-warning">启用</button></a>
                    @endif
                    <a href="{{ url('admin/admin/adminChange') }}/{{$v -> id}}"><input type="button" id="man_del" class="btn btn-xs btn-info" value="修改"/> </a>
                  <!-- <a href="{{ url('admin/admin/delete') }}/{{$v -> id}}" onclick="return foo();"><input type="button" id="man_del" class="btn btn-xs btn-danger del" value="删除"/> </a> -->
                    <button class="btn btn-xs btn-danger del" onclick="return getid({{ $v -> id }}) ">删除 </button>
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
                          <a href="{{ url('admin/admin/adminChange') }}/{{$v -> id}}" class="tooltip-success" data-rel="tooltip" title="Edit">
                            <span class="green">
                              <i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
                            </span>
                          </a>
                        </li>
                        <li>
                          <a href="{{ url('admin/admin/delete') }}/{{$v -> id}}" class="tooltip-error" data-rel="tooltip" title="Delete">
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
  <script src="{{ asset('admin/components/jquery/dist/jquery.js') }}"></script>
  <script src="{{ asset('admin/components/jquery.1x/dist/jquery.js') }}"></script>
  <script src="{{ asset('admin/myjs/admin/admin.js') }}"></script>
  <script type="text/javascript">
      var delUrl="{{ url('admin/admin/delete') }}/";
  </script>
@endsection
