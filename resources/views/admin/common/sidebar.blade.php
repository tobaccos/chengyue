<div class="main-container ace-save-state" id="main-container">
    <script type="text/javascript">
        try{ace.settings.loadState('main-container')}catch(e){}
    </script>

    <!-- #section:basics/sidebar -->
    <div id="sidebar" class="sidebar  responsive  ace-save-state">
        <script type="text/javascript">
            try{ace.settings.loadState('sidebar')}catch(e){}
        </script>
        <ul class="nav nav-list">
            <li>
                <a href="{{ url('admin/index') }}">
                    <i class="menu-icon  fa fa-home"></i>
                    <span class="menu-text"> 首页 </span>
                </a>
                <b class="arrow"></b>
            </li>
            @if(Session('ruleIndex'))
            <li id="product">
                <a href="#" class="dropdown-toggle">
                    <i class="menu-icon fa fa-list"></i>
                    <span class="menu-text">
								产品管理
							</span>
                    <b class="arrow fa fa-angle-down"></b>
                </a>

                <b class="arrow"></b>

                <ul class="submenu" style="padding-left: 36px;">

                        @foreach(Session('ruleIndex') as $v)
                            @if($v -> father_id == 1)
                            <li >

                                <a href="{{ url($v ->url) }}">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    {{ $v -> name }}
                                </a>
                                <b class="arrow"></b>
                            </li>
                            @endif
                        @endforeach

                </ul>
            </li>

            <li id="activity">
                <a href="#" class="dropdown-toggle">
                    <i class="menu-icon fa fa-gift"></i>
                    <span class="menu-text">促销管理 </span>

                    <b class="arrow fa fa-angle-down"></b>
                </a>

                <b class="arrow"></b>
                <ul class="submenu" style="padding-left: 36px;">
                    @foreach(Session('ruleIndex') as $v)
                        @if($v -> father_id == 2)
                            <li >
                                <a href="{{ url($v ->url) }}">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    {{ $v -> name }}
                                </a>
                                <b class="arrow"></b>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </li>
            <li id="user">
                <a href="#" class="dropdown-toggle">
                    <i class="menu-icon fa fa-user"></i>
                    <span class="menu-text"> 用户管理 </span>

                    <b class="arrow fa fa-angle-down"></b>
                </a>

                <b class="arrow"></b>

                <ul class="submenu" style="padding-left: 36px;">
                    @foreach(Session('ruleIndex') as $v)
                        @if($v -> father_id == 3)
                            <li >
                                <a href="{{ url($v ->url) }}">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    {{ $v -> name }}
                                </a>
                                <b class="arrow"></b>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </li>
            <li id="partner">
                <a href="#" class="dropdown-toggle">
                    <i class="menu-icon fa fa-users"></i>
                    <span class="menu-text">合作商家管理 </span>
                    <b class="arrow fa fa-angle-down"></b>
                </a>
                <b class="arrow"></b>
                <ul class="submenu" style="padding-left: 36px;">
                    @foreach(Session('ruleIndex') as $v)
                        @if($v -> father_id == 4)
                            <li >
                                <a href="{{ url($v ->url) }}">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    {{ $v -> name }}
                                </a>
                                <b class="arrow"></b>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </li>

            <li id="orders">
                <a href="#" class="dropdown-toggle">
                    <i class="menu-icon fa fa-file-o"></i>

                    <span class="menu-text">
								订单管理
							</span>

                    <b class="arrow fa fa-angle-down"></b>
                </a>

                <b class="arrow"></b>

                <ul class="submenu" style="padding-left: 36px;">
                    @foreach(Session('ruleIndex') as $v)
                        @if($v -> father_id == 5)
                            <li >
                                <a href="{{ url($v ->url) }}">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    {{ $v -> name }}
                                </a>
                                <b class="arrow"></b>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </li>
            <li id="admin">
              <a href="#" class="dropdown-toggle">
                <i class="menu-icon fa fa-wrench"></i>
                <span class="menu-text">
                  权限管理
                </span>
                <b class="arrow fa fa-angle-down"></b>
              </a>
              <b class="arrow"></b>
              <ul class="submenu" style="padding-left: 36px;">
                  @foreach(Session('ruleIndex') as $v)
                      @if($v -> father_id == 6)
                          <li >
                              <a href="{{ url($v ->url) }}">
                                  <i class="menu-icon fa fa-caret-right"></i>
                                  {{ $v -> name }}
                              </a>
                              <b class="arrow"></b>
                          </li>
                      @endif
                  @endforeach
                </ul>
            </li>

            <li id="set">
                <a href="#" class="dropdown-toggle">
                    <i class="menu-icon fa fa-cog"></i>

                    <span class="menu-text">
						系统设置
							</span>

                    <b class="arrow fa fa-angle-down"></b>
                </a>

                <b class="arrow"></b>

                <ul class="submenu" style="padding-left: 36px;">
                    @foreach(Session('ruleIndex') as $v)
                        @if($v -> father_id == 7)
                            <li >
                                <a href="{{ url($v ->url) }}">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    {{ $v -> name }}
                                </a>
                                <b class="arrow"></b>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </li>
            <li id="critical">
                <a href="#" class="dropdown-toggle">
                    <i class="menu-icon fa fa-pencil-square-o"></i>

                    <span class="menu-text">
						评论
							</span>

                    <b class="arrow fa fa-angle-down"></b>
                </a>

                <b class="arrow"></b>

                <ul class="submenu" style="padding-left: 36px;">
                    <li>
                        <a href="{{ url('admin/critical/ciritical') }}">
                            <i class="menu-icon fa fa-caret-right"></i>
                            评论管理
                        </a>

                        <b class="arrow"></b>
                    </li>
                </ul>
            </li>
            <li id="ad">
                <a href="#" class="dropdown-toggle">
                    <i class="menu-icon fa fa-file-image-o"></i>
                    <span class="menu-text">
                    广告管理
                        </span>

                    <b class="arrow fa fa-angle-down"></b>
                </a>

                <b class="arrow"></b>

                <ul class="submenu" style="padding-left: 36px;">
                    <li>
                        <a href="{{ url('admin/ad/index') }}">
                            <i class="menu-icon fa fa-caret-right"></i>
                            广告列表
                        </a>

                        <b class="arrow"></b>
                    </li>
                </ul>
            </li>
                @endif
        </ul><!-- /.nav-list -->

        <!-- #section:basics/sidebar.layout.minimize -->
        <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
            <i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
        </div>

        <!-- /section:basics/sidebar.layout.minimize -->
    </div>
