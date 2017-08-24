@extends('layouts.app')
@section('title')
@endsection
@section('content')

<form id="myForm"  method="POST" action="{{ route('login') }}">
        {{ csrf_field() }}    
    <input id="name" type="hidden" placeholder="" class="form-control" name="openid" value="{{ $name }}"  autofocus>
    <input id="password" type="hidden" class="form-control" name="password" placeholder="" value="{{ $password }}">
</form>
  
     <script src="{{ asset('js/jquery-3.0.0.min.js') }}"></script>
     <script>
      $(function(){
    	$('#myForm').submit();
	  });
    </script>
@endsection

