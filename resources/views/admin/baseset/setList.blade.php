@extends('admin.common.base')
@section('css')
    <link rel="stylesheet" href="{{ asset('admin/mycss/baseset.css') }}" />
    @endsection
@section('first_title','系统设置')
@section('second_title','网站设置')
@section('content')
    <div class="row">
        @if(count($errors)>0)
                @if(is_object($errors))
                    @foreach($errors->all() as $error)
                        <p>{{$error}}</p>
                    @endforeach
                @else
                    <p>{{$errors}}</p>
                @endif
        @endif
        <label class="col-xs-12">
            <form class="form-horizontal" role="form" id="commentForm">
                {{csrf_field()}}
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" > 网站名称 </label>
                    <div class="col-sm-9">
                        <input type="text" id="myname" name="webname"   class="col-xs-10 col-sm-5" value="{{$data['webname']}}" maxlength="20" ><br/>
                    </div>
                    <label class="col-sm-3 control-label no-padding-right" ></label>
                    {{--<div class="col-sm-9">--}}
                        {{--<p class="setinfo">网站名称,将显示在前台顶部欢迎信息等位置，最多输入20个字符</p>--}}
                    {{--</div>--}}
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" >网站邮箱</label>
                    <div class="col-sm-9">
                        <input type="text" id="myemail" name="webemail"  class="col-xs-10 col-sm-5" value="{{$data['webemail']}}" />
                    </div>
                    <label class="col-sm-3 control-label no-padding-right" ></label>
                    {{--<div class="col-sm-9">--}}
                        {{--<p class="setinfo">使用发送邮件的邮箱账号</p>--}}
                    {{--</div>--}}
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" >网站域名</label>
                    <div class="col-sm-9">
                        <input type="text" id="mycom" name="weburl"  class="col-xs-10 col-sm-5" value="{{$data['weburl']}}" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" >网站关键字</label>
                    <div class="col-sm-9">
                        <input type="text" id="mykey" name="webkeywords"  class="col-xs-10 col-sm-5" value="{{$data['webkeywords']}}" />
                    </div>
                    <label class="col-sm-3 control-label no-padding-right" ></label>
                    {{--<div class="col-sm-9">--}}
                        {{--<p class="setinfo">网站关键字，便于SEO</p>--}}
                    {{--</div>--}}
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" >网站描述</label>
                    <div class="col-sm-9">
                           <textarea class="col-xs-10 col-sm-5" id="myreg" name="webdescription" >{{$data['webdescription']}}</textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right"> 网站开关</label>
                    <div class="col-sm-9">
                        <select name="wkey">
                            @if($data['wkey'] == 1)
                                <option value="1" selected>开</option>
                                <option value="0" >关</option>
                            @elseif($data['wkey'] == 0)
                                <option value="1" >开</option>
                                <option value="0" selected>关</option>
                            @else
                                <option value="1" >开</option>
                                <option value="0" >关</option>
                            @endif
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" >  公司名称</label>
                    <div class="col-sm-9">
                        <input type="text" id="mycop" name="wname"  maxlength="18" class="col-xs-10 col-sm-5" value="{{$data['wname']}}" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" >公司手机</label>
                    <div class="col-sm-9">
                        <input type="text" id="mytel" name="wtel"  class="col-xs-10 col-sm-5" value="{{$data['wtel']}}" maxlength="11" onkeyup="if( !/^[1]+(\d{0,10})?$/.test(this.value)){this.value='';}"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" >公司电话</label>
                    <div class="col-sm-9">
                        <input type="text" id="mytel1" name="wtel1"  class="col-xs-10 col-sm-5" value="{{$data['wtel1']}}" onkeyup="if( !/^[\d-]*$/.test(this.value)){this.value='';}"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" >公司地址</label>
                    <div class="col-sm-9">
                        <input type="text" id="myaddress" name="waddress"  class="col-xs-10 col-sm-5" value="{{$data['waddress']}}" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" >公司版权</label>
                    <div class="col-sm-9">
                        <input type="text" id="mycopyright" name="wcopyright"  class="col-xs-10 col-sm-5" value="{{$data['wcopyright']}}"  />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" >注册声明</label>
                    <div class="col-sm-9">
                           <textarea class="col-xs-10 col-sm-5" id="myreg1" name="wstatement"  >{{$data['wstatement']}}</textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" >QQ客服</label>
                    <div class="col-sm-9">
                        <input type="text" id="myqq" name="qq_kf"  class="col-xs-10 col-sm-5" value="{{$data['qq_kf']}}" maxlength="20" onkeyup="if( !/^[\d-]*$/.test(this.value)){this.value='';}"/>
                    </div>
                    <label class="col-sm-3 control-label no-padding-right" ></label>
                    {{--<div class="col-sm-9">--}}
                        {{--<p class="setinfo">客服中心，方便用户遇到问题时咨询</p>--}}
                    {{--</div>--}}
                </div>


                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" >虚拟币比例</label>
                    <div class="col-sm-9">
                        <input type="text" id="mypro" name="scale"  class="col-xs-10 col-sm-5" value="{{$data['scale']}}" maxlength="5" onkeyup="if( !(/^-?\d+\.?\d{0,3}$/.test(this.value)){this.value='';}"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" >返利总利率</label>
                    <div class="col-sm-9">
                        <input type="text" id="myrebate" name="intetestrate"  class="col-xs-10 col-sm-5" value="{{$data['intetestrate']}}"   maxlength="5" onkeyup="if( !(/^-?\d+\.?\d{0,3}$/.test(this.value)){this.value='';}" />
                    </div>
                </div>

                <div class="clearfix form-actions">
                    <div class="col-md-offset-5 col-md-9">
                        <input class="btn btn-info"  id="setbtn" type="button" value="确认提交">
                        </button>
                    </div>

                </div>
            </form>
    </div>
@endsection
@section('js')
    <script>
        var webemail=/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        var mycom=/(?:http(?:s)?:\/\/)?(?:www\.)?(.*?)\./;
        var myqq=/^[1-9][0-9]{5,11}$/;
        var mytel=/^1[34578]\d{9}$/;
        var mytel1=/^([0-9]{3,4}-)?[0-9]{7,8}$/;
        var formUrl='{{url('admin/config/update')}}';
    </script>
    <script src="{{asset('admin/myjs/baseset.js')}}" type="text/javascript"></script>
    @endsection
