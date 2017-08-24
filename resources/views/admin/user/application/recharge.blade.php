@extends('admin.common.base')
@section('css')
<link rel="stylesheet" href="{{ asset('admin/mycss/common/alertwords.css') }}" />
<link rel="stylesheet" href="{{asset('admin/components/tablesorter/themes/blue/style.css') }}" />
<link rel="stylesheet" href="{{ asset('admin/mycss/user/userClass.css') }}" />
@endsection
@section('first_title','用户管理')
@section('second_title','充值记录')
@section('content')
<button class="btn-xs btn-info delBtnPo">删除所有记录</button>
<div class="row">
  <div class="col-xs-12">
    <!-- PAGE CONTENT BEGINS -->
    <div class="row">
      <div class="col-xs-12">
      <table id="simple-table" class="table  table-bordered table-hover dataTable tablesorter">
          <thead>
            <tr>
              <th>充值ID</th>
              <th>充值单号</th>
              <th>充值人姓名</th>
              <th>充值金额</th>
              <th>
                <i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i>
              充值时间
              </th>
              {{--<th>操作</th>--}}
            </tr>
          </thead>
          <tbody>
          @foreach($data as $v)
            <tr>
              <td>{{ $v -> id }}</td>
              <td>{{ $v -> recharge_sn }}</td>
              <td>{{ $v -> name }}</td>
              <td>{{ $v -> money }}</td>
              <td>{{ $v -> created_at }}</td>
              {{--<td><a href="{{ url('admin/user/application/recharge/del') }}/{{ $v ->id }}">删除</a></td>--}}
            </tr>
          @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<div style="text-align:center">
  {{ $data -> appends($request) -> links() }}
</div>
@endsection
@section('js')

<script src="{{ asset('admin/components/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('admin/components/tablesorter/jquery.tablesorter.min.js') }}"></script>
<script type="text/javascript">
  var delUrl = '{{ url('admin/user/application/recharge') }}';
</script>
<script src="{{ asset('admin/myjs/user/recharge.js') }}"></script>
<script type="text/javascript">
  $(document).ready(function() {
 	 $("#simple-table").tablesorter({
 		 headers:{
 			 0:{sorter:false},
 			 1:{sorter:false},
       2:{sorter:false},
 		 }
 	 });
 });
</script>

@endsection
