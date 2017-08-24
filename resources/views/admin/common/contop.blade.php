<div class="main-content">
    <div class="main-content-inner">
        <div class="breadcrumbs ace-save-state" id="breadcrumbs">
            <ul class="breadcrumb">
                <li>
                    <i class="ace-icon fa fa-home home-icon"></i>
                    <a href="#">@yield('first_title')</a>
                </li>
                <li class="active">@yield('second_title')</li>
            </ul>
        </div>

        <!-- 温馨提示 -->
        @if(session('info'))
            <div class="alert alert-info myalert">
                <button class="close" data-dismiss="alert">
                    <i class="ace-icon fa fa-times "></i>
                </button>
                <i class="fa fa-hand-pointer-o "></i>&nbsp;&nbsp;温馨提示:
                <div class="alertwords">
                    <p>{{session('info')}}</p>
                </div>
            </div>
        @elseif($errors -> any())
            <div class="alert alert-info myalert">
                <button class="close" data-dismiss="alert">
                    <i class="ace-icon fa fa-times "></i>
                </button>
                <i class="fa fa-hand-pointer-o "></i>&nbsp;&nbsp;温馨提示:
                <div class="alertwords">
                    <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                    @foreach($errors -> all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach

                </div>
            </div>
        @elseif(count($errors)>0)
            <div class="alert alert-info myalert">
                <button class="close" data-dismiss="alert">
                    <i class="ace-icon fa fa-times "></i>
                </button>
                <i class="fa fa-hand-pointer-o "></i>&nbsp;&nbsp;温馨提示:
                <div class="alertwords">
                    @if(is_object($errors))
                        @foreach($errors->all() as $error)
                            <p>温馨提示：{{$error}}</p>
                        @endforeach

                    @else
                        <p>温馨提示：{{$errors}}</p>
                    @endif

                </div>
            </div>
        @else


        @endif


        {{--引入主要内容--}}
        <div class="page-content">
            @yield('content')
        </div>
    </div>
</div>
