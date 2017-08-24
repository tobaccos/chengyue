<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta charset="utf-8" />
    <title>印汇商盟</title>
    <meta name="description" content="overview &amp; stats" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- bootstrap & fontawesome -->
    <link rel="stylesheet" href="{{ asset('admin/assets/css/bootstrap.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/components/font-awesome/css/font-awesome.css') }}"/>
    <!-- text fonts -->
    <link rel="stylesheet" href="{{ asset('admin/assets/css/ace-fonts.css') }}" />
    <!-- ace styles -->
    <link rel="stylesheet" href="{{ asset('admin/assets/css/ace.css') }}"  />
    <!--[if lte IE 9]>
    <link rel="stylesheet" href="{{ asset('admin/assets/css/ace-part2.css') }}"  />
    <![endif]-->
    <link rel="stylesheet" href="{{ asset('admin/assets/css/ace-skins.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/css/ace-rtl.css') }}" />
    <!--[if lte IE 9]>
    <link rel="stylesheet" href="{{ asset('admin/assets/css/ace-ie.css') }}" />
    <![endif]-->
    <link rel="stylesheet" href="{{ asset('admin/mycss/common/base.css') }}" />
    {{--属性--}}
    <link rel="stylesheet" href="{{ asset('admin/editable/css/jquery.editable-select.css') }}" />
@yield('css')
<!-- ace settings handler -->
    <script src="{{ asset('admin/assets/js/ace-extra.js') }}"></script>
    <!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->
    <!--[if lte IE 8]>
    <script src="{{ asset('admin/components/html5shiv/dist/html5shiv.min.js') }}"></script>
    <script src="{{ asset('admin/components/respond/dest/respond.min.js') }}"></script>
    <![endif]-->
</head>

<body class="no-skin">
{{--引入头部导航--}}
@include('admin.common.navbar')
{{--引入侧边栏--}}
@include('admin.common.sidebar')
{{--引入头部标题--}}
@include('admin.common.contop')


<!-- basic scripts -->
<script src="{{ asset('admin/components/jquery/dist/jquery.js') }}"></script>
<script src="{{ asset('admin/components/jquery.1x/dist/jquery.js') }}"></script>

<script type="text/javascript">
    if('ontouchstart' in document.documentElement) document.write("<script src='{{ asset("admin/components/_mod/jquery.mobile.custom/jquery.mobile.custom.js") }}'>"+"<"+"/script>");
</script>
<script src="{{ asset('admin/components/bootstrap/dist/js/bootstrap.js') }}"></script>
<!-- page specific plugin scripts -->
<!--[if lte IE 8]>
<script src="{{ asset('admin/components/ExplorerCanvas/excanvas.js') }}"></script>
<![endif]-->
<script src="{{ asset('admin/assets/js/src/ace.js') }}"></script>
<script src="{{ asset('admin/assets/js/src/ace.basics.js') }}"></script>
<script src="{{ asset('admin/assets/js/src/ace.sidebar.js') }}"></script>
<script src="{{ asset('common/layer/layer.js') }}"></script>

<link rel="stylesheet" href="{{ asset('admin/assets/css/ace.onpage-help.css') }}" />
<link rel="stylesheet" href="{{ asset('admin/docs/assets/js/themes/sunburst.css') }}" />
@yield('js')
</body>
</html>
