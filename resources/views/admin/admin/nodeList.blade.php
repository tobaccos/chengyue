@extends('admin.common.base')
@section('css')
<link rel="stylesheet" href="{{ asset('admin/mycss/common/alertwords.css') }}" />
<link rel="stylesheet" href="{{ asset('admin/mycss/admin/nodeList.css') }}" />
@endsection
@section('first_title','权限管理')
@section('second_title','节点管理')
@section('content')
  <a href="{{ url('admin/admin/nodeAdd') }}">
    <button class="btn btn-xs btn-info mybtn">
      <i class="ace-icon fa fa-bolt bigger-110"></i>
      添加节点
      <i class="ace-icon fa fa-arrow-right icon-on-right"></i>
    </button>
  </a>
<div class="row">
  <div class="col-xs-12">
    <!-- PAGE CONTENT BEGINS -->
    <div class="row">
      <div class="col-xs-12">
        <table id="simple-table" class="table  table-bordered table-hover " >
    <thead>
      <tr>
        {{--<th class="center detail-col">--}}
          {{--<label class="pos-rel">--}}
          {{--<input type="checkbox" class="ace" onclick="swapCheck()"/>--}}
            {{--<span class="lbl"></span>--}}
          {{--</label>--}}
          {{--</th>--}}
          <!-- <th>
              <input type="checkbox" value=""   onclick="swapCheck()">&nbsp;全选</input>
          </th> -->
        <th>编号</th>
        <th>描述</th>
        <th>操作</th>
      </tr>
    </thead>
    <tbody>
    @foreach($data as $v)
      <tr id="select" >
        <!-- <td class="center">
          <label class="pos-rel">
            <input type="checkbox"  />
            <span class="lbl"></span>
          </label>
        </td> -->
        <td>{{ $v -> id }}</td>
        <td>{{ $v -> name }}</td>
        <td>
          <a href="{{ url('admin/admin/nodeUpdate') }}/{{ $v -> id }}" >
						<button class="btn btn-xs btn-primary" value="" >修改</button>
					</a>&nbsp;
        <button class="btn btn-xs btn-danger del" onclick="return getid({{ $v -> id }}) ">删除 </button>
        </td>
      </tr>
      @endforeach
		</tbody>
  </table>
</div>
</div>
<div class="page" >
{{ $data -> appends($request) -> links() }}
</div>
</div>
</div>
@endsection
@section('js')
<script src="{{ asset('admin/components/jquery/dist/jquery.js') }}"></script>
<script src="{{ asset('admin/components/jquery.1x/dist/jquery.js') }}"></script>
<script src="{{ asset('admin/myjs/admin/nodeList.js') }}"></script>
<script type="text/javascript">
//checkbox 全选/取消全选
var isCheckAll = false;
var delUrl="{{ url('admin/admin/nodeDel') }}";
</script>
@endsection
