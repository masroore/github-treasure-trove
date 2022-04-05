@php
    Illuminate\Support\Facades\Cache::rememberForever('showrooms', function() {
       return \Modules\Inventory\Entities\ShowRoom::where('status', 1)->get();
    });
    Illuminate\Support\Facades\Cache::rememberForever('languages', function() {
       return \Modules\Localization\Entities\Language::where('status', 1)->get();
    });
    Illuminate\Support\Facades\Cache::rememberForever('date_format', function() {
       return \Modules\Setting\Model\DateFormat::where('status', 1)->get();
    });
@endphp
<div class="container-fluid no-gutters">
    <div class="row">
        <div class="col-lg-12 p-0">
            <div class="header_iner d-flex justify-content-between align-items-center">
                @if (!request()->is('pos/pos-order-products'))
                    <div class="small_logo_crm d-lg-none">
                        <a href="{{url('/login')}}">
                            <img src="{{ $setting->logo}}" alt=""></a>
                    </div>
                    <div id="sidebarCollapse" class="sidebar_icon  d-lg-none">
                        <i class="ti-menu"></i>
                    </div>
                    <div class="collaspe_icon open_miniSide">
                        <i class="ti-menu"></i>
                    </div>
                @endif
                <div class="serach_field-area ml-40">
                    @if (!request()->is('pos/pos-order-products') and auth()->user()->role->type != 'normal_user')
                        <div class="search_inner search_menu_suggestion">
                            <form action="#">
                                <div class="search_field">
                                    <input type="text" class="search_menu" placeholder="{{__('common.Search')}}">
                                </div>
                                <button><i class="ti-search"></i></button>
                            </form>
                            <div id="livesearch"></div>
                        </div>
                    @endif
                </div>
                <div class="header_middle d-none d-md-block">
                    <div class="select_style d-flex">
                        @if (auth()->user()->role->type == "system_user")
                            <select name="#" class="nice_Select select_showroom bgLess mb-0 ">
                                @foreach (Illuminate\Support\Facades\Cache::get('showrooms') as $key => $showroom)
                                    <option value="{{ $showroom->id }}"
                                            @if ($showroom->id == session()->get('showroom_id')) selected @endif>{{ $showroom->name }}</option>
                                @endforeach
                            </select>
                        @elseif (auth()->user()->role->type == "regular_user")
                            <select name="#" class="nice_Select select_showroom bgLess mb-0 ">
                                @if (showroomName() != null)
                                    <option value="" selected>{{ showroomName() }}</option>
                                @else
                                    <option value="" selected>{{ __('common.Login Again') }}</option>
                                @endif
                            </select>
                        @endif
                        @if(permissionCheck('language.change'))
                            <div class="border_1px"></div>
                            @php
                                if(session()->has('locale')){
                                    $locale = session()->get('locale');
                                }
                                else{
                                    session()->put('locale', app('general_setting')->language_name);
                                    $locale = session()->get('locale');
                                }
                            @endphp
                            <select name="code" id="language_code" class="nice_Select bgLess mb-0"
                                    onchange="change_Language()">
                                @foreach (Illuminate\Support\Facades\Cache::get('languages') as $key => $language)
                                    <option value="{{ $language->code }}"
                                            @if ($locale == $language->code) selected @endif>{{ $language->name }}</option>
                                @endforeach
                            </select>
                            @endif
                    </div>

                </div>
                <div class="header_middle d-none d-md-block">

                </div>
                <div class="header_right d-flex justify-content-between align-items-center">
                    @if (auth()->user()->role->type != "normal_user")
                        <div class="header_notification_warp d-flex align-items-center">
                            <ul>
                                <li>
                                    <a class="gredient_hover" href="{{ route('cashbook.index') }}">
                                        <i class="ti-agenda"></i>
                                    </a>
                                </li>
                                <li class="notification_warp_pop">
                                    <a class="popUP_clicker gredient_hover" href="#">
                                        <i class="ti-plus"></i>
                                    </a>
                                    <div class="menu_popUp_list_wrapper">
                                        <!-- popUp_single_wrap  -->
                                        <div class="popUp_single_wrap">
                                            @if (permissionCheck('sale.create'))
                                                <div class="popup_single_item">
                                                    <div class="main-title2 mb_10">
                                                        <h4 class="mb_15">{{ __('sale.Sales') }}</h4>
                                                    </div>
                                                    <ul>
                                                        <li><a href="{{ route('sale.create') }}"> <i
                                                                    class="ti-plus"></i> {{ __('sale.Add Sale') }}</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            @endif

                                            @if (permissionCheck('add_contact.store'))
                                                <div class="popup_single_item">
                                                    <div class="main-title2 mb_10">
                                                        <h4 class="mb_15">{{ __('contact.Contact') }}</h4>
                                                    </div>
                                                    <ul>
                                                        <li><a href="{{ route('add_contact.store') }}"> <i
                                                                    class="ti-plus"></i>{{ __('contact.Add Contact') }}
                                                            </a></li>
                                                    </ul>
                                                </div>
                                            @endif

                                            @if (permissionCheck('purchase_order.recieve.index'))
                                                <div class="popup_single_item">
                                                    <div class="main-title2 mb_10">
                                                        <h4 class="mb_15">{{ __('product.Products') }}</h4>
                                                    </div>
                                                    <ul>
                                                        <li><a href="{{ route('purchase_order.recieve.index') }}"> <i
                                                                    class="ti-plus"></i> {{ __('common.Recieve Product') }}
                                                            </a></li>
                                                    </ul>
                                                </div>
                                            @endif


                                        </div>
                                        <!-- popUp_single_wrap  -->
                                        <div class="popUp_single_wrap">
                                            @if (permissionCheck('purchase_order.create'))
                                                <div class="popup_single_item">
                                                    <div class="main-title2 mb_10">
                                                        <h4 class="mb_15">{{ __('purchase.Purchase') }}</h4>
                                                    </div>
                                                    <ul>
                                                        <li><a href="{{ route('purchase_order.create') }}"> <i
                                                                    class="ti-plus"></i> {{ __('purchase.Add Purchase') }}
                                                            </a></li>
                                                    </ul>
                                                </div>
                                            @endif

                                            @if (permissionCheck('transfer_showroom.create'))
                                                <div class="popup_single_item">
                                                    <div class="main-title2 mb_10">
                                                        <h4 class="mb_15">{{ __('account.Money Transfer') }}</h4>
                                                    </div>
                                                    <ul>
                                                        <li><a href="{{ route('transfer_showroom.create') }}"> <i
                                                                    class="ti-plus"></i>{{ __('account.Add Money Transfer') }}
                                                            </a></li>
                                                    </ul>
                                                </div>
                                            @endif

                                            @if (permissionCheck('staffs.create'))
                                                <div class="popup_single_item">
                                                    <div class="main-title2 mb_10">
                                                        <h4 class="mb_15">{{ __('common.Staff') }}</h4>
                                                    </div>
                                                    <ul>
                                                        <li><a href="{{ route('staffs.create') }}"> <i
                                                                    class="ti-plus"></i> {{ __('common.Add Staff') }}
                                                            </a></li>
                                                    </ul>
                                                </div>
                                            @endif


                                        </div>
                                        <!-- popUp_single_wrap  -->
                                        <div class="popUp_single_wrap">


                                            @if (permissionCheck('introPrefix.create'))
                                                <div class="popup_single_item">
                                                    <div class="main-title2 mb_10">
                                                        <h4 class="mb_15">{{ __('common.Intro Prefix') }}</h4>
                                                    </div>
                                                    <ul>
                                                        <li><a href="{{ route('introPrefix.index') }}"> <i
                                                                    class="ti-plus"></i>
                                                                {{ __('common.Add Intro Prefix') }}</a></li>
                                                    </ul>
                                                </div>
                                            @endif

                                            @if (permissionCheck('tax.create'))
                                                <div class="popup_single_item">
                                                    <div class="main-title2 mb_10">
                                                        <h4 class="mb_15">{{ __('account.Tax') }}</h4>
                                                    </div>
                                                    <ul>
                                                        <li><a href="{{ route('tax.index') }}"> <i
                                                                    class="ti-plus"></i> {{ __('account.Add Tax') }}</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            @endif

                                        </div>
                                        <!-- popUp_single_wrap  -->
                                        <div class="popUp_single_wrap">
                                            @if (permissionCheck('printer.create'))
                                                <div class="popup_single_item">
                                                    <div class="main-title2 mb_10">
                                                        <h4 class="mb_15">{{ __('common.Printer') }}</h4>
                                                    </div>
                                                    <ul>
                                                        <li><a href="{{ route('printer.index') }}"> <i
                                                                    class="ti-plus"></i> {{ __('common.Add Printer') }}
                                                            </a></li>
                                                    </ul>
                                                </div>
                                            @endif

                                            @if (permissionCheck('vouchers.create'))
                                                <div class="popup_single_item">
                                                    <div class="main-title2 mb_10">
                                                        <h4 class="mb_15">{{ __('common.Payments') }}</h4>
                                                    </div>
                                                    <ul>
                                                        <li><a href="{{ route('vouchers.create') }}"> <i
                                                                    class="ti-plus"></i>{{ __('account.Add Payments') }}
                                                            </a></li>
                                                    </ul>
                                                </div>
                                            @endif

                                            @if (permissionCheck('voucher_recieve.create'))
                                                <div class="popup_single_item">
                                                    <div class="main-title2 mb_10">
                                                        <h4 class="mb_15">{{ __('common.Recieve') }}</h4>
                                                    </div>
                                                    <ul>
                                                        <li>
                                                            <a href="{{ route('voucher_recieve.create') }}"> <i
                                                                    class="ti-plus"></i> {{ __('common.Add Recieve') }}
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            @endif

                                        </div>
                                    </div>
                                </li>

                                <li class="scroll_notification_list">
                                    <a class="pulse theme_color bell_notification_clicker" href="#" >
                                        <!-- bell   -->
                                        <i class="fa fa-bell"></i>

                                        <!--/ bell   -->
                                        <span class="notification_count notification_count_text">{{count($notifications)}}  </span>
                                        <span class="notification_count_pulse {{count($notifications) > 0 ? 'pulse-ring' : ''}}"></span>
                                    </a>
                                    <!-- Menu_NOtification_Wrap  -->
                                    <div class="Menu_NOtification_Wrap">
                                        <div class="notification_Header">
                                            <h4>{{__('common.Notifications')}}</h4>
                                        </div>
                                        <div class="Notification_body">

                                            @if (app('business_settings')->where('type','system_notification')->where('status',1)->first())
                                                @foreach ($notifications as $key => $notification)

                                                    <div class="single_notify d-flex align-items-center">

                                                        <div class="notify_content">
                                                            <a href="{{$notification->url}}"
                                                               onclick="notification_remove({{$notification->id}},'{{$notification->url}}')">
                                                                <h5>{{$notification->type}} </h5></a>
                                                            <p >{{$notification->data}}</p>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif

                                        </div>
                                        <div class="nofity_footer">
                                            <div class="submit_button text-center pt_20">
                                                <a href="{{route('all_notifications')}}"
                                                   class="primary-btn radius_30px text_white  fix-gr-bg">{{__('product.See More')}}</a>
                                                @if(count($notifications))
                                                    <span class="primary-btn radius_30px text_white notification_icon fix-gr-bg">{{__('common.Mark as seen')}}</span>
                                                    @endif
                                            </div>
                                        </div>
                                    </div>
                                    <!--/ Menu_NOtification_Wrap  -->
                                </li>
                            </ul>
                        </div>
                    @endif

                    <div class="profile_info">
                        <img
                            src="{{asset(Auth::user()->avatar != null ? Auth::user()->avatar : "public/img/profile.jpg")}}"
                            alt="#">
                        <div class="profile_info_iner">
                            <p>{{__('common.Welcome')}} {{ Auth::user()->role->name }}!</p>
                            <h5>{{ Auth::user()->name }}</h5>
                            <div class="profile_info_details">
                                @if(permissionCheck('company_information_update'))
                                    <a href="{{route('company_info')}}">{{ __('common.Company Info') }} <i
                                            class="ti-user"></i></a>
                                @endif
                                @if(Auth::user()->staff)
                                    <a href="{{ route('profile_view') }}">{{ __('common.Profile') }} <i
                                            class="ti-settings"></i></a>
                                @elseif(Auth::user()->contact)
                                    <a href="{{ route('contact.profile') }}">{{ __('common.Profile') }} <i
                                            class="ti-settings"></i></a>
                                @endif

                                    <a href="{{ route('change_password') }}">{{ __('common.Change Password') }} <i
                                            class="ti-key"></i></a>

                                <a href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                    <i class="ti-shift-left"></i>
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script type="text/javascript">
        function change_Language() {
            var code = $('#language_code').val();
            $.post('{{ route('language.change') }}', {_token: '{{ csrf_token() }}', code: code}, function (data) {

                if (data.success) {
                    window.location.reload(true);
                    toastr.success(data.success);
                } else {
                    toastr.error(data.error);
                }
            });
        }

        $(document).on('change', '.select_showroom', function () {
            let id = $(this).val();
            $.ajax({
                method: "POST",
                url: "{{route('change.showroom')}}",
                data: {
                    id: id,
                    _token: "{{csrf_token()}}",
                },
                success: function (result) {
                    window.location.reload(true);
                }
            })
        })

        $(document).on('keyup', '.search_menu', function () {
            let value = $(this).val();
            let _token = "{{csrf_token()}}";
            $.ajax({
                method: "POST",
                url: "{{route('menu.search')}}",
                data: {
                    value: value,
                    _token: _token,
                },
                success: function (result) {
                    $("#livesearch").show();
                    $("#livesearch").html(result);
                }
            })
        })

        $(document).on('click', '.notification_icon', function(){
            $('.notification_count_text').text('0').addClass('notification_count').removeClass('notification_count_pulse')
            $('.notification_count_pulse').removeClass('pulse-ring');
            $.ajax({
                url: "{{route('mark_notifications')}}",
                method: "get",
                success: function (result) {
                }
            })
        });

        function notification_remove(id, url) {
            $.ajax({
                url: "{{route('notification.update')}}",
                method: "POST",
                data: {
                    id: id,
                    _token: "{{csrf_token()}}",
                },
                success: function (result) {
                }
            })
        }
    </script>
@endpush
