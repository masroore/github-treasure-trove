<!DOCTYPE html>
<html lang="cn">
<head>
    <title>{{ env('APP_NAME') }}</title>
    <meta charset="utf-8"/>
    <meta name="description" content="overview &amp; stats"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- STYLES -->
    <link rel="stylesheet" href="{{ asset('/assets/css/theme.css?v=20211006104500') }}"/>
    <link href="{{ asset('assets/css/bootstrap.min.css?v=20211006104500') }}" rel="stylesheet"/>
    <link href="{{ asset('assets/css/bootstrap-overrides.css?v=20211006104500') }}" rel="stylesheet"/>
    <link rel="stylesheet" href="{{ asset('/assets/css/font-awesome.min.css?v=20211006104500') }}"/>
    <link rel="icon" type="image/png" href="{{ cAsset('/assets/css/img/logo.png') }}" sizes="192x192">
    <link href="{{ asset('/assets/css/chosen.css?v=20211006104500') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/assets/css/colorbox.css') }}" />
    <link rel="stylesheet" href="{{ asset('/assets/css/ace.min.css?v=20211006104500') }}"/>
    <link rel="stylesheet" href="{{ asset('/assets/css/ace-rtl.min.css?v=20211006104500') }}"/>
    <link rel="stylesheet" href="{{ asset('/assets/css/ace-skins.min.css?v=20211006104500') }}"/>
    <link rel="stylesheet" href="{{ asset('/assets/css/jquery.gritter.css') }}" />
    <link rel="stylesheet" href="{{ asset('/assets/css/base.css') }}" />
    <link href="{{ asset('/assets/css/datepicker.css') }}" rel="stylesheet">
    <link href="{{ asset('/assets/css/bootstrap-timepicker.css') }}" rel="stylesheet">
    <link href="{{ asset('/assets/css/daterangepicker.css') }}" rel="stylesheet">
    <link href="{{ asset('/assets/css/colorpicker.css') }}" rel="stylesheet">
    <link href="{{ asset('/assets/css/jquery-ui-1.10.3.full.min.css')}}" rel="stylesheet">
    <link href="{{ asset('/assets/css/jquery.treeview.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/style.css?v=20211006104500') }}" rel="stylesheet">
    <link href="{{ asset('/css/common.css?v=20211006104500') }}" rel="stylesheet">
    @yield('styles')

    <!-- SCRIPTS -->
    <script src="{{ asset('/assets/js/ace-extra.min.js') }}"></script>
    <script src="{{ asset('/assets/js/jquery-2.0.3.min.js') }}"></script>
    <script src="{{ asset('/assets/js/ace-elements.min.js') }}"></script>
    <script src="{{ asset('/assets/js/fuelux/fuelux.tree.min.js') }}"></script>
    <script src="{{ asset('/assets/js/jquery.treeview.js') }}"></script>
    <script src="{{ asset('/assets/js/bootbox.min.js') }}"></script>
    <script src="{{ asset('/assets/js/ace.min.js') }}"></script>
    <script src="{{ asset('/assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/assets/js/typeahead-bs2.min.js') }}"></script>
    <script src="{{ asset('/assets/js/jquery-ui-1.10.3.full.min.js') }}"></script>
    <script src="{{ asset('/assets/js/jquery.ui.touch-punch.min.js') }}"></script>
    <script src="{{ asset('/assets/js/date-time/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('/assets/js/chosen.jquery.min.js') }}"></script>
    <script src="{{ asset('/assets/js/jquery.gritter.min.js')}}"></script>
    <script src="{{ asset('/assets/js/jquery.toast.min.js')}}"></script>
    <script src="{{ asset('/assets/js/jquery.slides.js')}}"></script>
    <script src="{{ asset('/assets/js/util.js')}}"></script>
</head>

<script type="text/javascript">
    try{ace.settings.loadState('sidebar')}catch(e){}
</script>

<?php
    $routeName = Request::route()->getName();
    $menuList = Session::get('menusList');
    $id = Request::get('menuId');
    $isAdmin = Auth::user()->isAdmin;
	$role = Auth::user()->pos;
?>

<body class="skin-1">
<header id="header">
    <div class="navbar navbar-inverse navbar-static-top" role="navigation">
        <div class="container">
            <div class="navbar-header" style="width:10%;">
                <a href="/home" class="navbar-brand for-pc">
                    <img class="navbar-img" src="{{ asset('/assets/avatars/logo.png') }}" alt=""/>
                </a>
                <a class="navbar-brand for-sp">
                    <img class="navbar-img" style="padding: 8px;" src="{{ asset('/assets/avatars/logo.png') }}" alt=""/>
                </a>
            </div>
            <div class="sp-logout for-sp">
                <li class="dropdown" style="height: auto;">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="background: transparent;">
                        <img src="{{ Auth::user()->avatar == '' ? cAsset('assets/avatars/user.png') : Auth::user()->avatar }}" height="24" width="24" style="vertical-align: middle; border-radius: 50%;">
                        欢迎 | {{ Auth::user()->realname }}</a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('logout') }}"><i class="icon-signout"></i>&nbsp;&nbsp;{{ trans('common.label.logout') }}</a></li>
                    </ul>
                </li>
            </div>
            
            
            <div id="menuToggle" class="sp-menu sidebar">
                <input type="checkbox" class="hamburger-input"/>
                <span></span>
                <span></span>
                <span></span>

                <ul class="nav nav-pills nav-list" id="menu" style="overflow: visible;{{ $role == STAFF_LEVEL_CAPTAIN || $role == STAFF_LEVEL_SHAREHOLDER ? 'justify-content: unset!important;' : '' }}">
				    @if($role != STAFF_LEVEL_CAPTAIN && $role != STAFF_LEVEL_SHAREHOLDER)
						<li>
							<a href="{{ route('home') }}">
								首页
							</a>
						</li>
						@if($role == STAFF_LEVEL_MANAGER)
						<li>
							<a href="/decision/receivedReport">
								审批
							</a>
						</li>
						@endif
					@endif
                    @if($role != STAFF_LEVEL_CAPTAIN)
                    <li style="overflow: auto; position: static;">
                        <a href="#" class="dropdown-toggle text-center">
                            分析
                        </a>
                        <ul class="submenu nav-hide" style="position: absolute; left: 0; right: 0; width: 100%; border-bottom: 1px solid #1865c1;overflow: visible!important;z-index: 10000;">
                            @if($role != STAFF_LEVEL_SHAREHOLDER)
                            <li class="d-in-block text-center" style="width: 32%;overflow: visible; position: static;">
                                <a href="#" class="dropdown-toggle">
                                    船舶
                                </a>

                                <ul class="submenu nav-hide" style="position: absolute; left: 0; right: 0; width: 100%; text-align: justify; margin-top: 7px;">
                                    <li class="d-in-block">
                                        <a href="/shipManage/shipinfo">
                                            规范
                                        </a>
                                    </li>

                                    <li class="d-in-block">
                                        <a href="/shipManage/dynamicList">
                                            动态分析
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="d-in-block text-center" style="width: 32%;overflow: visible; position: static;">
                                <a href="#" class="dropdown-toggle">
                                    海员
                                </a>

                                <ul class="submenu nav-hide" style="position: absolute; left: 0; right: 0; width: 100%; text-align: justify; margin-top: 7px;">
                                    <li class="d-in-block">
                                        <a href="/shipMember/totalShipMember">
                                            CREW LIST
                                        </a>
                                    </li>

                                    <li class="d-in-block">
                                        <a href="/shipMember/wagesList">
                                            工资(船舶)
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            @endif
                            @if($role != STAFF_LEVEL_CAPTAIN)
                            <li class="d-in-block text-center" style="width: 32%;overflow: visible; position: static;">
                                <a href="#" class="dropdown-toggle">
                                    收支
                                </a>

                                <ul class="submenu nav-hide" style="position: absolute; left: 0; right: 0; width: 100%; text-align: justify; margin-top: 7px;">
                                    <li class="d-in-block">
                                        <a href="/operation/incomeExpense">
                                            收支(船只)
                                        </a>
                                    </li>

                                    <li class="d-in-block">
                                        <a href="/shipManage/ctm/analytics">
                                            CTM 分析
                                        </a>
                                    </li>

                                    <li class="d-in-block">
                                        <a href="/shipManage/voy/evaluation">
                                            航次评估
                                        </a>
                                    </li>
                                </ul>
                            </li>
							@endif
                        </ul>
                    </li>
					@endif
                    @if($role != STAFF_LEVEL_SHAREHOLDER)
                    <li>
                        <a href="#" class="dropdown-toggle text-center">
                            记录
                        </a>
                        <ul class="submenu nav-hide" style="position: fixed; left: 0; width: 100%; border-bottom: 1px solid #1865c1;">
                            <li class="d-in-block text-center">
                                <a href="/voy/register" class="dropdown-toggle">
                                    动态记录
                                </a>
                            </li>
                        </ul>
                    </li>
					@endif
                </ul>
            </div>
            <div class="sp-menu overlay-show" id="overlay-div" style="display: none;"></div>

            <div class="collapse navbar-collapse navbar-ex1-collapse" role="navigation">
                <ul class="nav navbar-nav navbar-right" style="position: absolute; right: 2%;">
                    @if(Auth::user()->isAdmin == STAFF_LEVEL_MANAGER || Auth::user()->pos == STAFF_LEVEL_MANAGER)
                        <li>
                            <a href="/decision/receivedReport?menuId=11" style="padding: 8px; display: flex;">
                                <i class="icon-bell bigger-110"></i>
                                <span class="bell-badge" data-val="" style="display: none;" id="unread_receive">0</span>
                            </a>
                        </li>
                    @elseif(Auth::user()->pos == STAFF_LEVEL_FINANCIAL)
                        <li>
                            <a href="/finance/books?menuId=39" style="padding: 8px; display: flex;">
                                <i class="icon-bell bigger-110"></i>
                                <span class="bell-badge" data-val="" style="display: none;" id="unread_receive">0</span>
                            </a>
                        </li>
                    @endif
                    <li class="dropdown" style="height: auto;">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="background: transparent;">
                            <img src="{{ Auth::user()->avatar == '' ? cAsset('assets/avatars/user.png') : Auth::user()->avatar }}" height="24" width="24" style="vertical-align: middle; border-radius: 50%;">
                            欢迎 | {{ Auth::user()->realname }}<b class="caret"></b></a>
                        <ul class="dropdown-menu" style="background: #5b79a5;">
                            <li><a href="{{ route('profile') }}"><i class="icon-user"></i>&nbsp;&nbsp;&nbsp;{{ trans('common.label.profile') }}</a></li>
                            <hr style="margin: 4px 0!important;">
                            <li><a href="{{ route('logout') }}"><i class="icon-signout"></i>&nbsp;&nbsp;{{ trans('common.label.logout') }}</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div id="container">
                <nav>
                    <ul class="pc-menu">
                        @if(Auth::user()->pos != STAFF_LEVEL_SHAREHOLDER && Auth::user()->pos != STAFF_LEVEL_CAPTAIN)
                            <li class="{{ $routeName == 'home' ? 'menu-active' : '' }} parent">
                                <a href="/">{{ trans('home.title.dashboard') }}</a>
                            </li>
                        @endif

                        @foreach($menuList as $key => $item)
                            @if($item['parent'] == 0)
                                <li class="{{ ($routeName != 'home' && in_array($id, $item['ids'])) ? 'menu-active' : '' }} parent">
                                    @if($item['controller'] == '')
                                        <a href="/{{ $item['children'][0]['controller'] . '?menuId=' . $item['id'] }}" class="link">{{ $item['title'] }}</a>
                                    @else
                                        <a href="/{{ $item['controller'] . '?menuId=' . $item['id'] }}" class="link">{{ $item['title'] }}</a>
                                    @endif
                                    <ul class="children">
                                        @foreach($item['children'] as $key => $sub)
                                            <li>
                                                <a href="/{{ $sub['controller'] == '' ? (count($sub['children']) > 0 ? $sub['children'][0]['controller'] : '') : ($isAdmin && $sub['id'] == 12 ? 'decision/analyzeReport' : $sub['controller']) }}{{ '?menuId=' . $sub['id'] }}">{{ $isAdmin && $sub['id'] == 12 ? '审批分析' : $sub['title'] }}
                                                    @if(count($sub['children']) > 0)
                                                        <img class="has-child" src="{{ cAsset('assets/img/icons/right-arrow.png') }}">
                                                    @endif
                                                </a>
                                                <ul class="children third-level">
                                                    @foreach($sub['children'] as $value)
                                                        <li><a href="/{{ $value['controller'] . '?menuId=' . $value['id'] }}">{{ $value['title'] }}</a></li>
                                                    @endforeach
                                                </ul>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</header>

<script>
    var PUBLIC_URL = '{{ cAsset('/') . '/' }}';
    var BASE_URL = PUBLIC_URL;
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    });
</script>
<div class="main-container {{ $routeName == 'home' || $routeName == 'home.index' ? '' : 'inner-wrap' }}" style="{{ $routeName == 'shipmember.list' || $routeName == 'income.ship' || $routeName == 'income.all' || $routeName == 'wages.calc' || $routeName == 'wages.send' || $routeName == 'wages.calc.report' || $routeName == 'wages.send.report' ? 'width:100%; height: 100%!impotant;' : '' }}" id="main-container">
    <div class="main-container-inner {{ $routeName == 'decision.report' || $routeName == 'system.settings' ? 'custom-height' : '' }}">
        @if(isset($breadCrumb) && count($breadCrumb) > 0)
            <div class="breadcrumbs ace-save-state" id="breadcrumbs">
                <ul class="breadcrumb">
                    <li>
                        <a>首页</a>
                    </li>
                    @foreach($breadCrumb as $key => $item)
                        @if($key + 1 == count($breadCrumb))
                            <li class="active">
                                <span>{{ $item->title }}</span>
                            </li>
                        @else
                            <li>
                                <a>{{ $item->title }}</a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        @elseif($routeName == 'org.add' || $routeName == 'profile')
            <div class="breadcrumbs ace-save-state" id="breadcrumbs">
                <ul class="breadcrumb">
                    <li>
                        <a>首页</a>
                    </li>
                    @foreach($breadList as $key => $item)
                        @if($key + 1 == count($breadList))
                            <li class="active">
                                <span>{{ $item[1] }}</span>
                            </li>
                        @else
                            <li>
                                <a>{{ $item[1] }}</a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        @endif
        @yield('content')
    </div>

    <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
        <i class="icon-double-angle-up icon-only bigger-110"></i>
    </a>
</div>
<button id="trigger-btn" type="button" class="d-none"></button>

<footer class="footer d-none">
    <p class="footer-title">
        <a href="/"><span class="blue bolder" style="line-height: 1;">JSS</span></a>&nbsp; &nbsp;船舶管理信息系统 ©  {{ (date('Y') - 1) . ' ~ ' . date('Y')  }}</span>&nbsp; &nbsp;
    </p>
</footer>
<audio controls="controls" class="d-none" id="warning-audio">
    <source src="{{ cAsset('assets/sound/delete.wav') }}">
    <embed src="{{ cAsset('assets/sound/delete.wav') }}" type="audio/wav">
</audio>
<audio controls="controls" class="d-none" id="alert-audio">
    <source allow="autoplay" src="{{ cAsset('assets/sound/alert.mp3') }}">
    <embed allow="autoplay" src="{{ cAsset('assets/sound/alert.mp3') }}" type="audio/mp3">
</audio>
<script type="text/javascript">
    window.jQuery || document.write("<script src='/assets/js/jquery-1.10.2.min.js'>" + "<" + "/script>");
</script>
<script src="{{ asset('js/__common.js') }}"></script>
<script src="{{ asset('/assets/js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('/assets/js/jquery.inputlimiter.min.js') }}"></script>
<script src="{{ asset('/assets/js/jquery.maskedinput.min.js') }}"></script>
<script src="{{ asset('/assets/js/ship_process.js') }}"></script>
<script src="{{ cAsset('assets/js/moment.js') }}"></script>
@yield('scripts')
</body>
</html>
<script>
    $(function() {
        $('#trigger-btn').click();
    });
</script>