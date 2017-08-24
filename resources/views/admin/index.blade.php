@extends('admin.common.base')
@section('css')
    <link rel="stylesheet" href="{{ asset('admin/mycss/index.css') }}" />
@endsection
@section('first_title','欢迎使用印汇商盟系统管理')
@section('second_title','首页')

@section('content')
    <div class="row">
        <div class="space-6"></div>
        <div  id="con">
            <div class="infobox  info_orange margin_25">
                <div class="infobox-icon">
                    <i class="fa fa-user indexicon"></i>
                </div>

                <div class="infobox-data indexfont">
                    <span class="infobox-data-number">&nbsp;{{$data['pt_num']}}</span>
                    <div class="infobox-content">普通用户总数</div>
                </div>
            </div>
            <div class="infobox  info_green margin_25">
                <div class="infobox-icon">
                    <i class="fa fa-user-plus indexicon"></i>
                </div>

                <div class="infobox-data indexfont">
                    <span class="infobox-data-number">&nbsp;{{$data['dl_num']}}</span>
                    <div class="infobox-content">代理商总数</div>
                </div>
            </div>
            <div class="infobox  info_littlegreen margin_25">
                <div class="infobox-icon">
                    <i class="fa fa-money indexicon"></i>
                </div>

                <div class="infobox-data indexfont">
                    <span class="infobox-data-number">&nbsp;{{$data['tx_num']}}</span>
                    <div class="infobox-content">提现申请总数</div>
                </div>
            </div>

            <div class="infobox  info_red margin_25">
                <div class="infobox-icon">
                    <i class="fa fa-files-o indexicon"></i>
                </div>

                <div class="infobox-data indexfont">
                    <span class="infobox-data-number">&nbsp;{{$data['ddz_num']}}</span>
                    <div class="infobox-content">订单总数</div>
                </div>
            </div>
            <div class="infobox  info_littleorange margin_25">
                <div class="infobox-icon">
                    <i class="fa fa-file-o indexicon"></i>
                </div>

                <div class="infobox-data indexfont">
                    <span class="infobox-data-number">&nbsp;{{$data['dzzdd_num']}}</span>
                    <div class="infobox-content">待制作订单总数</div>
                </div>
            </div>
            <div class="infobox  info_littlered margin_25">
                <div class="infobox-icon">
                    <i class="fa fa-file-text-o indexicon"></i>
                </div>

                <div class="infobox-data indexfont">
                    <span class="infobox-data-number">&nbsp;{{$data['dfhdd_num']}}</span>
                    <div class="infobox-content">待发货订单总数</div>
                </div>
            </div>
            <div class="infobox  info_blue margin_25">
                <div class="infobox-icon">
                    <i class="fa fa-truck indexicon"></i>
                </div>

                <div class="infobox-data indexfont">
                    <span class="infobox-data-number">&nbsp;{{$data['yfhdd_num']}}</span>
                    <div class="infobox-content">已发货订单总数</div>
                </div>
            </div>
        </div>
    </div><!-- /.row -->
@endsection