@extends('admin.common.base')
@section('css')
<link rel="stylesheet" href="{{ asset('admin/mycss/common/alertwords.css') }}" />
<link rel="stylesheet" href="{{ asset('admin/mycss/partner/list.css') }}" />
@endsection
@section('first_title','合作商家管理')
@section('second_title','合作商家列表')
@section('content')

  <a href="{{ url('admin/partner/partnerAdd') }}">
    <button class="btn btn-xs btn-info myadd ">
      <i class="ace-icon fa fa-bolt bigger-110"></i>
      添加商家
      <i class="ace-icon fa fa-arrow-right icon-on-right"></i>
    </button>
  </a>
<div class="row">
  <div class="col-xs-12">
    <!-- PAGE CONTENT BEGINS -->
    <div class="row">
      <div class="col-xs-12">
        <table id="simple-table" class="table  table-bordered table-hover tab1" >
          <thead>
            <tr>
              {{--<th class="center detail-col">--}}
                {{--<label class="pos-rel">--}}
                {{--<input type="checkbox" class="ace" onclick="swapCheck()"/>--}}
                  {{--<span class="lbl"></span>--}}
                {{--</label>--}}
                {{--</th>--}}
                <th class="detail-col">编号</th>
                <th>名称</th>
                {{--<th>记录人</th>--}}
                <th>商家logo</th>
                <th>跳转地址</th>
                <th class="hidden-480">
                  <i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i>
                  记录时间
                </th>
                <th class="hidden-480">
                  <i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i>
                  更新时间
                </th>
                <th >操作</th>
              </tr>
            </thead>
            <tbody>
            @foreach($data as $v)
              <tr>
                {{--<td class="center">--}}
                  {{--<label class="pos-rel">--}}
                    {{--<input type="checkbox" class="ace" />--}}
                    {{--<span class="lbl"></span>--}}
                  {{--</label>--}}
                {{--</td>--}}
                <td>{{ $v -> id }}</td>
                <td>{{ $v -> name }}</td>
                <td><img height="50"
                         @if($v -> pic == '')
                         src="{{ url('/uploads/product/cate/default.jpg') }}"
                         @else
                         src="{{ url('/uploads/product/cate') }}/{{ $v -> pic }}"
                          @endif
                  /></td>
                <td>{{ $v -> url }}</td>
                <td class="hidden-480">{{ $v -> created_at }}</td>
                <td class="hidden-480">{{ $v -> updated_at }}</td>
                <td>
                  <div class="hidden-sm hidden-xs ">
                    <a href="{{ url('admin/partner/partnerChange') }}/{{ $v -> id }}"><input type="button" id="man_del" class="btn btn-xs btn-info" value="修改"/> </a>
                      <a href="{{ url('admin/partner/delete') }}/{{ $v -> id }}"><input type="button" id="man_del" class="btn btn-xs btn-danger" value="删除"/> </a>
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
                          <a href="{{ url('admin/partner/partnerChange') }}/{{ $v -> id }}" class="tooltip-success" data-rel="tooltip" title="Edit">
                            <span class="green">
                              <i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
                            </span>
                          </a>
                        </li>
                        <li>
                          <a href="{{ url('admin/partner/delete') }}/{{ $v -> id }}" class="tooltip-error" data-rel="tooltip" title="Delete">
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
  <script src="{{ asset('admin/components/jquery/dist/jquery.js') }}"></script>
  <script src="{{ asset('admin/components/jquery.1x/dist/jquery.js') }}"></script>
  <script type="text/javascript">
   //checkbox 全选/取消全选
   var isCheckAll = false;
   function swapCheck() {
     if (isCheckAll) {
       $("input[type='checkbox']").each(function() {
         this.checked = false;
       });
       isCheckAll = false;
     } else {
       $("input[type='checkbox']").each(function() {
         this.checked = true;
       });
       isCheckAll = true;
     }
   }
   </script>
   @endsection
